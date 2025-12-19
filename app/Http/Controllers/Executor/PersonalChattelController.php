<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChattelType;
use App\Models\PersonalChattel;
use Illuminate\Support\Facades\Auth;

class PersonalChattelController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $chattelTypes = ChattelType::where('created_by', $contextUser->id)->get();
        $personalChattels = PersonalChattel::where('created_by', $contextUser->id)->get();

        return view('executor.assets.personal_chattels', compact('personalChattels', 'chattelTypes'));
    }
}
