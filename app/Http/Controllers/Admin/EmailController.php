<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class EmailController extends Controller
{
    public function create()
    {
        return view('admin.emails.create');
    }

    public function send(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'recipient_type' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        // Initialize an empty collection to hold users
        $users = collect();

        // Determine recipients based on selection
        if ($request->recipient_type === 'customers') {
            $users = User::role('customer')->get();
        } elseif ($request->recipient_type === 'partners') {
            $users = User::role('partner')->get();
        } elseif ($request->recipient_type === 'customers_and_partners') {
            $users = User::role(['customer', 'partner'])->get();
        }

        // Send email to each recipient
        foreach ($users as $user) {
            Mail::to($user->email)->send(new CustomEmail(
                [
                    'subject' => $request->title,
                    'message' => $request->message,
                ],
                $request->title
            ));
        }

        return redirect()->back()->with('success', 'Emails sent successfully.');
    }

    public function email_using_template()
    {
        return view('admin.emails.email_using_template');
    }
}
