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
        } elseif ($request->recipient_type === 'customers_free_trial') {
            $users = User::role('customer')
                ->where('subscribed_package', 'free_trial')
                ->get();
        } elseif ($request->recipient_type === 'customers_lifetime_basic') {
            $users = User::role('customer')
                ->where('subscribed_package', 'Lifetime Basic')
                ->get();
        } elseif ($request->recipient_type === 'customers_lifetime_standard') {
            $users = User::role('customer')
                ->where('subscribed_package', 'Lifetime Standard')
                ->get();
        } elseif ($request->recipient_type === 'customers_lifetime_premium') {
            $users = User::role('customer')
                ->where('subscribed_package', 'Lifetime Premium')
                ->get();
        } elseif ($request->recipient_type === 'customers_monthly_basic') {
            $users = User::role('customer')
                ->where('subscribed_package', 'Basic')
                ->get();
        } elseif ($request->recipient_type === 'customers_monthly_standard') {
            $users = User::role('customer')
                ->where('subscribed_package', 'Standard')
                ->get();
        } elseif ($request->recipient_type === 'customers_monthly_premium') {
            $users = User::role('customer')
                ->where('subscribed_package', 'Premium')
                ->get();
        } elseif ($request->recipient_type === 'partners') {
            $users = User::role('partner')->get();
        } elseif ($request->recipient_type === 'customers_and_partners') {
            $users = User::role(['customer', 'partner'])->get();
        }

        $signature = '
        <br><br>
        <p><b>Executor Hub Team</b></p>
        <p><b>Executor Hub Ltd</b></p>
        <p><b>Empowering Executors, Ensuring Legacies</b></p>
        <p><b>Email: hello@executorhub.co.uk</b></p>
        <p><b>Website: https://executorhub.co.uk</b></p>
        <p><b>ICO Registration: ZB932381</b></p>
        <p><b>This email and any attachments are confidential and intended solely for the recipient.</b></p>
        <p><b>If you are not the intended recipient, please delete it and notify the sender.</b></p>
        <p><b>Executor Hub Ltd accepts no liability for any errors or omissions in this message.</b></p>
        <a href="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/active/?source=email">
            <img alt="Cyber Essentials logo" src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/email-image/?width=153&height=153" width="153" height="153" oncontextmenu="return false;"/>
        </a>
    ';

        foreach ($users as $user) {
            Mail::to($user->email)->send(new CustomEmail(
                [
                    'subject' => $request->title,
                    'message' => $request->message . $signature,
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

        $signature = '
        <br><br>
        <p><b>Executor Hub Team</b></p>
        <p><b>Executor Hub Ltd</b></p>
        <p><b>Empowering Executors, Ensuring Legacies</b></p>
        <p><b>Email: hello@executorhub.co.uk</b></p>
        <p><b>Website: https://executorhub.co.uk</b></p>
        <p><b>ICO Registration: ZB932381</b></p>
        <p><b>This email and any attachments are confidential and intended solely for the recipient.</b></p>
        <p><b>If you are not the intended recipient, please delete it and notify the sender.</b></p>
        <p><b>Executor Hub Ltd accepts no liability for any errors or omissions in this message.</b></p>
        <a href="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/active/?source=email">
            <img alt="Cyber Essentials logo" src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/email-image/?width=153&height=153" width="153" height="153" oncontextmenu="return false;"/>
        </a>
    ';

        $messageWithSignature = $request->message . $signature;

        if ($request->action === 'send') {
            foreach ($recipients as $recipient) {
                Mail::to($recipient->email)->send(new DynamicEmail(
                    $request->title,
                    $messageWithSignature,
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
                    'body' => $messageWithSignature,
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
    // Partners
    if ($type === 'partners') {
        return User::role('partner')->get();
    }

    // All customers
    if ($type === 'customers') {
        return User::role('customer')->get();
    }

    // Customer package mapping
    $packageMap = [
        'customers_free_trial'          => 'free_trial',
        'customers_lifetime_basic'      => 'Lifetime Basic',
        'customers_lifetime_standard'   => 'Lifetime Standard',
        'customers_lifetime_premium'    => 'Lifetime Premium',
        'customers_monthly_basic'       => 'Basic',
        'customers_monthly_standard'    => 'Standard',
        'customers_monthly_premium'     => 'Premium',
    ];

    // Customers by package
    if (array_key_exists($type, $packageMap)) {
        return User::role('customer')
            ->where('subscribed_package', $packageMap[$type])
            ->get();
    }

    // Specific user
    if ($type === 'select_specific_user' && $specificUserId) {
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
