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
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png',
            'reminder_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $path = $this->imageUpload($request->file('file'), 'documents');
            $fullPath = public_path('assets/upload/' . $path);    // now we have the full path

            $document = Document::create([
                'document_type' => $request->document_type,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => Auth::id(),
                'reminder_date' => $request->reminder_date,
                'reminder_type' => $request->reminder_type,
                'textpdf' =>'this is just testing',
            ]);

            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['document_uploaded' => true]
            );

            if (!$progress->document_uploaded) {
                $progress->document_uploaded = true;
                $progress->save();
            }
            DB::commit();
            // Send email
            $user = Auth::user();
            $data = [
                'first_name' => $user->name,
                'document_name' => $document->document_type,
            ];

            // Send push notification
            if ($user->expo_token) {
                $expo = new Expo();
                $message = new ExpoMessage([
                    'title' => 'New Document Uploaded',
                    'body' => "Your document '{$document->document_type}' has been successfully uploaded.",
                ]);
                $expo->send($message)->to($user->expo_token)->push();
            }

            Mail::to($user->email)->send(new DocumentMail($data));

            return response()->json(['success' => true, 'message' => 'Document added successfully.']);
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
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
            'reminder_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $document = Document::findOrFail($id);

            $document->document_type = $request->document_type;
            $document->description = $request->description;
            $document->reminder_type = $request->edit_reminder_type;

            $document->created_by = Auth::id();

            if ($request->hasFile('file')) {
                // Delete the file from the public/assets/upload directory
                $filePath = public_path('assets/upload/' . basename($document->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'documents');
                $document->file_path = $path;
            }

            $document->reminder_date = $request->reminder_date;
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
