<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
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

            return response()->json([
                'success' => true,
                'data' => [
                    'documents' => $documents,
                    'document_types' => $documentTypes,
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
}
