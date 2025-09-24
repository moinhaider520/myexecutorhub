<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowledgebaseController extends Controller
{
    public function index()
    {
        return view('knowledgebase.index');
    }

    public function email_templates()
    {
        return view('knowledgebase.email_templates');
    }
    public function suggested_scripts()
    {
        return view('knowledgebase.suggested_scripts');
    }

    public function short_call_openers()
    {
        return view('knowledgebase.short_call_openers');
    }
    public function whatsapp_texts()
    {
        return view('knowledgebase.whatsapp_texts');
    }
    public function social_media_direct_messages()
    {
        return view('knowledgebase.social_media_direct_messages');
    }
    public function social_media_posts()
    {
        return view('knowledgebase.social_media_posts');
    }

    public function quick_start_guide()
    {
        return view('knowledgebase.quick_start_guide');
    }
    public function best_practices()
    {
        return view('knowledgebase.best_practices');
    }
    public function client_reactivation()
    {
        return view('knowledgebase.client_reactivation');
    }
    public function entry_example()
    {
        return view('knowledgebase.entry_example');
    }
    
    


}
