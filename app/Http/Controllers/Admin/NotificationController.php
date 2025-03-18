<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

class NotificationController extends Controller
{
    public function create()
    {
        return view('admin.notifications.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        // Retrieve users based on recipient type and filter for those with expo_token
        $users = collect();
        if ($request->recipient_type === 'customers') {
            $users = User::role('customer')->whereNotNull('expo_token')->get();
        } elseif ($request->recipient_type === 'partners') {
            $users = User::role('partner')->whereNotNull('expo_token')->get();
        } elseif ($request->recipient_type === 'customers_and_partners') {
            $users = User::role(['customer', 'partner'])->whereNotNull('expo_token')->get();
        }
    
        // Prepare Expo push notifications
        $expo = new Expo();
        $messages = [];
        $expoTokens = [];
    
        foreach ($users as $user) {
            if ($user->expo_token) {
                $expoTokens[] = $user->expo_token;
                $messages[] = new ExpoMessage([
                    'title' => $request->title,
                    'body' => $request->message,
                ]);
            }
        }
    
        // Send Expo push notifications only if there are valid tokens
        if (!empty($expoTokens)) {
            $expo->send($messages)->to($expoTokens)->push();
        }
    
        return redirect()->route('admin.notifications.create')->with('success', 'Notification sent successfully!');
    }
}
