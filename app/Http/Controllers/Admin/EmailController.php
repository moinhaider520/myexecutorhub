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
    public function index()
    {
        $emails = EmailSchedule::orderBy('created_at', 'desc')->get();
        return view('admin.emails.index', compact('emails'));
    }


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
        $validationRules = [
            'recipient_type' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
            'action' => 'required|string',
        ];

        if ($request->action === 'schedule') {
            $validationRules['scheduled_at'] = 'required|date|after:now';
        }

        if ($request->recipient_type === 'select_specific_user') {
            $validationRules['specific_user_id'] = 'required|exists:users,id';
        }

        $request->validate($validationRules);

        $recipients = $this->getRecipients(
            $request->recipient_type,
            $request->specific_user_id
        );

        if ($recipients->isEmpty()) {
            return back()->with('error', 'No recipients found for the selected type.');
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
            $localScheduledTime = Carbon::parse($request->scheduled_at);
            $scheduledTimeUtc = $localScheduledTime->copy()->setTimezone('UTC');
            foreach ($recipients as $recipient) {
                EmailSchedule::create([
                    'recipient_email' => $recipient->email,
                    'subject' => $request->title,
                    'body' => $request->message,
                    'recipient_type' => $request->recipient_type,
                    'status' => 'pending',
                    'scheduled_for' => $scheduledTimeUtc,
                ]);
            }
            return back()->with('success', 'Emails scheduled successfully for ' . $localScheduledTime->format('Y-m-d H:i') . '!');
        }
    }

    private function getRecipients($type, $specificUserId = null)
    {
        if ($type === 'partners') {
            return User::role('partner')->get();
        } elseif ($type === 'customers') {
            return User::role('customer')->get();
        } elseif ($type === 'select_specific_user' && $specificUserId) {
            $user = User::find($specificUserId);
            return $user ? collect([$user]) : collect();
        }

        return collect();
    }

    public function users_list()
    {
        try {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'customer')
                    ->orWhere('name', 'partner');
            })->with('roles')->get();
            return response()->json(['users' => $users], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
