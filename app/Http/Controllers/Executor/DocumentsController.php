<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentTypes;
use Illuminate\Support\Facades\Auth;

class DocumentsController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $contextUser = ContextHelper::user();
        // Retrieve document types and documents created by the authenticated user
        $documentTypes = DocumentTypes::where('created_by', $contextUser->id)->get();
        $documents = Document::where('created_by', $contextUser->id)->get();

        return view('executor.documents.documents', compact('documents', 'documentTypes'));
    }
}
