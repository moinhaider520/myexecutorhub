<?php

namespace App\Http\Controllers\Partner;

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
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Illuminate\Support\Facades\Http;
class DocumentsController extends Controller
{
    use CloudinaryUpload;

    public function view()
    {
        $documentTypes = DocumentTypes::where('created_by', Auth::id())->get();
        $documents = Document::where('created_by', Auth::id())->get();

        $usedDocumentTypes = $documents->pluck('document_type')->unique()->toArray();

        return view('partner.documents.documents', compact('documents', 'documentTypes', 'usedDocumentTypes'));
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

            $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/documents');
            $extractedText = $this->extract($request);
            $document = Document::create([
                'document_type' => $request->document_type,
                'description' => $request->description,
                'file_path' => $upload['url'],
                'file_public_id' => $upload['public_id'],
                'created_by' => Auth::id(),
                'reminder_date' => $request->reminder_date,
                'reminder_type' => $request->reminder_type,
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

    public function extract(Request $request)
    {
        $uploaded = $request->file('file'); // from your HTML form field name="file"

        $resp = Http::asMultipart()
            ->attach('file', fopen($uploaded->getRealPath(), 'r'), $uploaded->getClientOriginalName())
            ->post('http://16.171.35.45:8000/extract', [
                'lang'               => 'eng',
                'dpi'                => 300,
                'ocr_psm'            => 3,
                'force_ocr'          => false,
                'ocr_on_empty_only'  => true,
                'include_text_preview' => false,
            ]);

        return response()->json($resp->json(), $resp->status());
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
                $this->deleteStoredFile($document->file_path, $document->file_public_id);
                $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/documents');
                $document->file_path = $upload['url'];
                $document->file_public_id = $upload['public_id'];
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
            $this->deleteStoredFile($document->file_path, $document->file_public_id);

            // Delete the document record
            $document->delete();
            DB::commit();
            return redirect()->route('partner.documents.view')->with('success', 'Document deleted successfully.');
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

    private function deleteStoredFile(?string $path, ?string $publicId): void
    {
        if (!empty($publicId)) {
            $this->deleteFromCloud($publicId);
            return;
        }

        if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        $filePath = public_path('assets/upload/' . basename($path));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
