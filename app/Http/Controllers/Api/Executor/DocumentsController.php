<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentTypes;
use Illuminate\Support\Facades\Auth;

class DocumentsController extends Controller
{
    /**
     * Display a list of documents and document types for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id)
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve document types and documents created by the authenticated user's creator
            $documentTypes = DocumentTypes::where('created_by', $id)->get();
            $documents = Document::where('created_by', $id)->get();

            $usedDocumentTypes = $documents->pluck('document_type')->unique()->toArray();

            return response()->json([
                'success' => true,
                'data' => [
                    'documents' => $documents,
                    'documentTypes' => $documentTypes,
                    'usedDocumentTypes' => $usedDocumentTypes
                ]
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve documents',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function ViewByDocType($document_type, $id)
    {
        try {
            $documents = Document::where('created_by', $id)
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
                'created_by' => $request->created_by,
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
            $document->created_by = $request->created_by;

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
}
