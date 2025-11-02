<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\OnboardingProgress;
use App\Mail\DocumentMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Traits\ImageUpload;
use App\Models\DocumentTypes;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Smalot\PdfParser\Parser;
use Spatie\PdfToText\Pdf;


class DocumentsController extends Controller
{
    use ImageUpload;

    public function view()
    {
        $documentTypes = DocumentTypes::where('created_by', Auth::id())->get();
        $documents = Document::where('created_by', Auth::id())->get();

        $usedDocumentTypes = $documents->pluck('document_type')->unique()->toArray();

        return view('customer.documents.documents', compact('documents', 'documentTypes', 'usedDocumentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'description' => 'required',
            'files' => 'required',
            'files.*' => 'file|max:20480', // up to 20MB per file
            'reminder_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $storedFiles = [];
            $text = null;

            foreach ($request->file('files') as $file) {
                $path = $this->imageUpload($file, 'documents');
                $storedFiles[] = $path;

                // Optional text extraction for PDFs
                $extension = strtolower($file->getClientOriginalExtension());
                if ($extension === 'pdf') {
                    try {
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile(public_path('assets/upload/' . $path));
                        $text .= "\n" . $pdf->getText();
                    } catch (\Exception $e) {
                        // skip text extraction errors silently
                    }
                }
            }

            // Store JSON array of file paths
            $document = Document::create([
                'document_type' => $request->document_type,
                'description' => $request->description,
                'file_path' => json_encode($storedFiles),
                'created_by' => Auth::id(),
                'reminder_date' => $request->reminder_date,
                'reminder_type' => $request->reminder_type,
                'textpdf' => mb_convert_encoding($text, 'UTF-8', 'UTF-8') ?? null,
            ]);

            // Update onboarding progress
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['document_uploaded' => true]
            );

            if (!$progress->document_uploaded) {
                $progress->document_uploaded = true;
                $progress->save();
            }

            DB::commit();

            // Send email + push
            $user = Auth::user();
            $data = [
                'first_name' => $user->name,
                'document_name' => $document->document_type,
            ];

            if ($user->expo_token) {
                $expo = new \ExpoSDK\Expo();
                $message = new \ExpoSDK\ExpoMessage([
                    'title' => 'New Document Uploaded',
                    'body' => "Your documents for '{$document->document_type}' have been uploaded.",
                ]);
                $expo->send($message)->to($user->expo_token)->push();
            }

            \Mail::to($user->email)->send(new \App\Mail\DocumentMail($data));

            return response()->json(['success' => true, 'message' => 'Documents uploaded successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }



    public function update(Request $request, $id)
{
    $request->validate([
        'document_type' => 'required|string|max:255',
        'description' => 'required',
        'files' => 'nullable',
        'files.*' => 'file|max:20480', // up to 20MB per file
        'reminder_date' => 'nullable|date',
    ]);

    try {
        DB::beginTransaction();

        $document = Document::findOrFail($id);

        $document->document_type = $request->document_type;
        $document->description = $request->description;
        $document->reminder_type = $request->edit_reminder_type;
        $document->created_by = Auth::id();
        $document->reminder_date = $request->reminder_date;

        $storedFiles = [];
        $text = null;

        // If new files are uploaded, replace old ones
        if ($request->hasFile('files')) {
            // Delete previous uploaded files (if exist)
            if (!empty($document->file_path)) {
                $oldFiles = json_decode($document->file_path, true);
                if (is_array($oldFiles)) {
                    foreach ($oldFiles as $oldFile) {
                        $filePath = public_path('assets/upload/' . $oldFile);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }
            }

            // Upload and store new files
            foreach ($request->file('files') as $file) {
                $path = $this->imageUpload($file, 'documents');
                $storedFiles[] = $path;

                // Optional: extract text from PDFs
                $extension = strtolower($file->getClientOriginalExtension());
                if ($extension === 'pdf') {
                    try {
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile(public_path('assets/upload/' . $path));
                        $text .= "\n" . $pdf->getText();
                    } catch (\Exception $e) {
                        // skip text extraction errors silently
                    }
                }
            }

            $document->file_path = json_encode($storedFiles);
            $document->textpdf = mb_convert_encoding($text, 'UTF-8', 'UTF-8') ?? null;
        }

        $document->save();

        DB::commit();

        return response()->json(['success' => true, 'message' => 'Document updated successfully.']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $document = Document::findOrFail($id);
            // Delete the file from the public/assets/upload directory
            $filePath = public_path('assets/upload/' . basename($document->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the document record
            $document->delete();
            DB::commit();
            return redirect()->route('customer.documents.view')->with('success', 'Document deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_document_type' => 'required|string|max:255|unique:document_types,name'
        ]);

        DocumentTypes::create([
            'name' => $request->custom_document_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
