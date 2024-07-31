<?php

namespace App\Http\Controllers\Others;

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
        
        // Retrieve document types and documents created by the authenticated user
        $documentTypes = DocumentTypes::where('created_by', $user->created_by)->get();
        $documents = Document::where('created_by', $user->created_by)->get();
        
        return view('others.documents.documents', compact('documents', 'documentTypes'));
    }
}