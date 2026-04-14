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
use App\Traits\CloudinaryUpload;
use App\Models\DocumentTypes;
use App\Services\DeathCertificateWorkflowService;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Smalot\PdfParser\Parser;
use Spatie\PdfToText\Pdf;


class DocumentsController extends Controller
{
    use CloudinaryUpload;

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
            $verificationUploadMeta = null;

            foreach ($request->file('files') as $file) {
                if ($verificationUploadMeta === null) {
                    $verificationUploadMeta = [
                        'document_sha256' => hash_file('sha256', $file->getRealPath()),
                        'uploaded_file_name' => $file->getClientOriginalName(),
                        'uploaded_file_size' => $file->getSize(),
                    ];
                }

                $upload = $this->uploadFileToCloud($file, 'executorhub/documents');
                $storedFiles[] = [
                    'url' => $upload['url'],
                    'public_id' => $upload['public_id'],
                ];

                // Optional text extraction for PDFs
                $extension = strtolower($file->getClientOriginalExtension());
                if ($extension === 'pdf') {
                    try {
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile($file->getRealPath());
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

            app(DeathCertificateWorkflowService::class)->createForDocument(
                document: $document,
                customerId: Auth::id(),
                uploadedBy: Auth::id(),
                uploadMeta: $verificationUploadMeta ?? [],
            );

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
            $oldFiles = $this->decodeStoredFiles($document->getRawOriginal('file_path'));
            $this->deleteStoredFiles($oldFiles);

            // Upload and store new files
            foreach ($request->file('files') as $file) {
                $upload = $this->uploadFileToCloud($file, 'executorhub/documents');
                $storedFiles[] = [
                    'url' => $upload['url'],
                    'public_id' => $upload['public_id'],
                ];

                // Optional: extract text from PDFs
                $extension = strtolower($file->getClientOriginalExtension());
                if ($extension === 'pdf') {
                    try {
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile($file->getRealPath());
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
            $oldFiles = $this->decodeStoredFiles($document->getRawOriginal('file_path'));
            $this->deleteStoredFiles($oldFiles);

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

    private function decodeStoredFiles($storedFiles): array
    {
        if (is_array($storedFiles)) {
            return $storedFiles;
        }

        if (empty($storedFiles)) {
            return [];
        }

        $decoded = json_decode($storedFiles, true);
        return is_array($decoded) ? $decoded : [$storedFiles];
    }

    private function deleteStoredFiles(array $storedFiles): void
    {
        foreach ($storedFiles as $file) {
            if (is_array($file) && !empty($file['public_id'])) {
                $this->deleteFromCloud($file['public_id']);
                continue;
            }

            $path = is_array($file) ? ($file['url'] ?? null) : $file;
            if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
                continue;
            }

            $filePath = public_path('assets/upload/' . basename($path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
