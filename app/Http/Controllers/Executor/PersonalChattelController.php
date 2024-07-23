<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChattelType;
use App\Models\PersonalChattel;
use Illuminate\Support\Facades\Auth;

class PersonalChattelController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve chattel types and personal chattels created by the authenticated user
        $chattelTypes = ChattelType::where('created_by', $user->created_by)->get();
        $personalChattels = PersonalChattel::where('created_by', $user->created_by)->get();
        
        return view('executor.assets.personal_chattels', compact('personalChattels', 'chattelTypes'));
    }
}
