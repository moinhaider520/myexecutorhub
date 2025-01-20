<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{
    public function getUsers()
    {
        $roles = ['executor', 'Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'];
        $user = Auth::user();
        
        if ($user->hasRole('customer') || $user->hasRole('partner')) {
            $users = User::with('roles')
                ->where('created_by', $user->id)
                ->whereHas('roles', function ($query) use ($roles) {
                    $query->whereIn('name', $roles);
                })
                ->get();
        } elseif ($user->hasAnyRole($roles)) {
            // For users with any of the specified roles
            $users = User::where('id', $user->created_by)->get();
        } else {
            $users = User::all();
        }

        return response()->json(['users' => $users], 200);
    }

    public function getMessages($userId)
    {
        $authUserId = Auth::id();
        $messages = Message::where(function($query) use ($authUserId, $userId) {
            $query->where('user_id', $authUserId)
                ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($authUserId, $userId) {
            $query->where('user_id', $userId)
                ->where('receiver_id', $authUserId);
        })->orderBy('id', 'asc')->get();

        // Mark messages as seen
        Message::where('user_id', $userId)
            ->where('receiver_id', $authUserId)
            ->update(['is_seen' => true]);

        return response()->json(['messages' => $messages], 200);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|integer|exists:users,id',
        ]);

        $message = new Message;
        $message->message = $request->message;
        $message->user_id = Auth::id();
        $message->receiver_id = $request->receiver_id;   

        $message->save();

        return response()->json(['message' => 'Message sent successfully'], 200);
    }
}
