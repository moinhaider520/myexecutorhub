<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\DynamicEmail;
use App\Models\EmailSchedule;
use Carbon\Carbon;
class EmailController extends Controller
{
    public function create()
    {
        return view('admin.emails.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $users = collect();

        // Determine recipients based on selection
        if ($request->recipient_type === 'customers') {
            $users = User::role('customer')->get();
        } elseif ($request->recipient_type === 'partners') {
            $users = User::role('partner')->get();
        } elseif ($request->recipient_type === 'customers_and_partners') {
            $users = User::role(['customer', 'partner'])->get();
        }

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



    public function store(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
            'action' => 'required|string',
        ]);

        $recipients = $this->getRecipients($request->recipient_type);

        if ($recipients->isEmpty()) {
            return back()->with('error', 'No recipients found.');
        }

        if ($request->action === 'send') {
            foreach ($recipients as $recipient) {
                Mail::to($recipient->email)->send(new DynamicEmail(
                    $request->title,
                    $request->message,
                    $recipient->name ?? 'User'
                ));
            }

            return back()->with('success', 'Emails sent successfully!');
        }

        if ($request->action === 'schedule') {

            foreach ($recipients as $recipient) {
                EmailSchedule::create([
                    'recipient_email' => $recipient->email,
                    'subject' => $request->title,
                    'body' => $request->message,
                    'recipient_type' => $request->recipient_type,
                    'status' => 'pending',
                    'scheduled_for' => Carbon::now()->addHours(2), // example delay
                ]);
            }

            return back()->with('success', 'Emails scheduled successfully!');
        }
    }

    private function getRecipients($type)
    {
        if ($type === 'partners') {
            return User::role('partner')->get();
        } elseif ($type === 'customers') {
            return  User::role('customer')->get();
        }
        return collect();
    }
}
