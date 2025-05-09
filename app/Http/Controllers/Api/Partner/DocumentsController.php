<?php

namespace App\Http\Controllers\Api\Partner;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\OnboardingProgress;
use App\Mail\DocumentMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Traits\ImageUpload;
use App\Models\DocumentTypes;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

class DocumentsController extends Controller
{
    use ImageUpload;

    /**
     * Display a list of documents for the authenticated partner.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $documentTypes = DocumentTypes::where('created_by', Auth::id())->get();
            $documents = Document::where('created_by', Auth::id())->get();
            
            $usedDocumentTypes = $documents->pluck('document_type')->unique()->toArray();
            
            return response()->json([
                'success' => true,
                'documents' => $documents,
                'documentTypes' => $documentTypes,
                'usedDocumentTypes' => $usedDocumentTypes
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display documents of a specific type for the authenticated partner.
     *
     * @param  string  $document_type
     * @return \Illuminate\Http\JsonResponse
     */
    public function ViewByDocType($document_type)
    {
        try {
            $documents = Document::where('created_by', Auth::id())
                ->where('document_type', $document_type)
                ->get();

            return response()->json([
                'success' => true,
                'documents' => $documents,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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

            $document = Document::create([
                'document_type' => $request->document_type,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => Auth::id(),
                'reminder_date' => $request->reminder_date,
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

    /**
     * Update the specified document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Remove the specified document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
            
            return response()->json(['success' => true, 'message' => 'Document deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom document type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_document_type' => 'required|string|max:255|unique:document_types,name'
        ]);

        try {
            DocumentTypes::create([
                'name' => $request->custom_document_type,
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom document type added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}