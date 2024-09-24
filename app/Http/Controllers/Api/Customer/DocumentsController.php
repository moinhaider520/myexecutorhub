<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;
use App\Models\DocumentTypes;

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
            return response()->json([
                'success' => true,
                'documents' => $documents,
                'documentTypes' => $documentTypes
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
        ]);

        try {
            DB::beginTransaction();

            $path = $this->imageUpload($request->file('file'), 'documents');

            Document::create([
                'document_type' => $request->document_type,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Document added successfully.'], 201);
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
            'file' => 'file|mimes:pdf,doc,docx,jpg,png',
        ]);

        try {
            DB::beginTransaction();

            $document = Document::findOrFail($id);

            $document->document_type = $request->document_type;
            $document->description = $request->description;
            $document->created_by = Auth::id();

            if ($request->hasFile('file')) {
                $filePath = public_path('assets/upload/' . basename($document->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'documents');
                $document->file_path = $path;
            }

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
