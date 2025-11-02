<?php

namespace App\Http\Controllers\Api\Customer;

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
     * Display a list of documents for the authenticated customer.
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
     * Display documents of a specific type for the authenticated customer.
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
        try {
            $request->validate([
                'document_type' => 'required|string|max:255',
                'description' => 'required|string',
                'file.*' => 'required|file|mimes:pdf,doc,docx,jpg,png',
                'reminder_date' => 'nullable|date',
            ]);

            DB::beginTransaction();

            $files = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = $this->imageUpload($file, 'documents');
                    $files[] = $path;
                }
            } else {
                return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
            }

            $document = Document::create([
                'document_type' => $request->document_type,
                'description' => $request->description,
                'file_path' => json_encode($files),
                'reminder_type' => $request->reminder_type,
                'created_by' => Auth::id(),
                'reminder_date' => $request->reminder_date,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Document added successfully']);
        } catch (\Throwable $e) {
            DB::rollBack();
            // Log and return the actual error message to the client for debugging
            \Log::error('Document store failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
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
            'description' => 'required|string',
            'file' => 'nullable',
            'reminder_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $document = Document::findOrFail($id);
            $document->document_type = $request->document_type;
            $document->description = $request->description;
            $document->reminder_type = $request->reminder_type;
            $document->created_by = Auth::id();

            $existingFiles = json_decode($document->file_path ?? '[]', true);

            // If new files are uploaded, append to the array
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = $this->imageUpload($file, 'documents');
                    $existingFiles[] = $path;
                }
            }

            $document->file_path = json_encode($existingFiles);
            $document->reminder_date = $request->reminder_date;
            $document->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Document updated successfully.'], 200);
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
            $filePath = public_path('assets/upload/' . basename($document->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

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