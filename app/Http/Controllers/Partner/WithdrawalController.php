<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Mail;

class WithdrawalController extends Controller
{
    /**
     * Display the withdraw page.
     */
    public function view()
    {
        return view('partner.withdraw.withdraw');
    }

    /**
     * Process the withdrawal request.
     */
    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:5', // Ensure amount is at least 5
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        // Check if the amount has decimals
        if (floor($amount) != $amount) {
            return back()->with('error', 'Withdrawal amount must be a whole number.');
        }

        // Check if the user has enough commission amount to withdraw
        if ($user->commission_amount < $amount) {
            return back()->with('error', 'Insufficient commission amount to make this withdrawal.');
        }

        // Create a withdrawal record
        Withdrawal::create([
            'user_id' => $user->id,
            'amount_requested' => $amount,
            'status' => 'pending',
        ]);

        // Deduct the requested amount from the user's commission amount
        $user->decrement('commission_amount', $amount);

        // Send email notification
        $toEmail = 'hello@executorhub.co.uk';
        $subject = 'Withdrawal Request Notification';
        $messageBody = "Dear Admin,\n\n"
            . "The partner {$user->name} (Email: {$user->email}) has requested a withdrawal of {$amount}.\n\n"
            . "Please review the request.\n\n"
            . "Best regards,\n"
            . "ExecutorHub Team";

        Mail::raw($messageBody, function ($message) use ($toEmail, $subject) {
            $message->to($toEmail)
                ->subject($subject);
        });

        return back()->with('success', 'Your withdrawal request has been submitted for processing.');
    }

    public function history()
    {
        $user = Auth::user();

        // Fetch all withdrawals for the logged-in user
        $withdrawals = Withdrawal::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('partner.withdraw.history', compact('withdrawals'));
    }
}
