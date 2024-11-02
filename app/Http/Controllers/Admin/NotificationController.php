<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SendNotification;

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

        $users = collect();

        if ($request->recipient_type === 'customers') {
            $users = User::role('customer')->get();
        } elseif ($request->recipient_type === 'partners') {
            $users = User::role('partner')->get();
        } elseif ($request->recipient_type === 'customers_and_partners') {
            $users = User::role(['customer', 'partner'])->get();
        }

        foreach ($users as $user) {
            $user->notify(new SendNotification($request->title, $request->message));
        }

        return redirect()->route('admin.notifications.create')->with('success', 'Notification sent successfully!');
    }
}
