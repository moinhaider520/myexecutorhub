<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowledgebaseController extends Controller
{
    public function index()
    {
        return view('knowledgebase.index');
    }
}
