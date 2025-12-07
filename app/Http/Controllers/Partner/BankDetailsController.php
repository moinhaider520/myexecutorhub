<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;

class BankDetailsController extends Controller
{
    /**
     * Show payout / bank status page for partner
     */
    public function index()
    {
        $user = Auth::user();

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $accounts = \Stripe\Account::allExternalAccounts(
            $user->stripe_connect_account_id,
            ['object' => 'bank_account']
        );

        return view('partner.bank_details.index', [
            'stripe_banks' => $accounts->data,
            'user'=>$user,
        ]);
    }

    /**
     * Start or continue Stripe Connect onboarding
     *
     * This replaces the old "store()" where you were saving IBAN etc.
     */
    public function connect()
    {
        $user = Auth::user();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 1) Create Connect account if not exists
        if (!$user->stripe_connect_account_id) {
            $account = Account::create([
                'type'    => 'express',
                'country' => 'GB', // ExecutorHub is UK-based
                'email'   => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers'     => ['requested' => true],
                ],
                'business_type' => 'individual',
            ]);

            $user->update([
                'stripe_connect_account_id' => $account->id,
            ]);
        } else {
            // Optionally fetch to check status
            $account = Account::retrieve($user->stripe_connect_account_id);
        }

        // 2) Create onboarding link
        $accountLink = AccountLink::create([
            'account'     => $account->id,
            'refresh_url' => route('partner.bank_details.refresh'),
            'return_url'  => route('partner.bank_details.success'),
            'type'        => 'account_onboarding',
        ]);

        return redirect($accountLink->url);
    }

    /**
     * Called when user hits "refresh" during onboarding
     * (Stripe sends them here if they click back/refresh)
     */
    public function refresh()
    {
        return redirect()->route('partner.bank_details.connect')
            ->with('info', 'Please complete your payout onboarding to enable bank transfers.');
    }

    /**
     * Called when Stripe onboarding is completed successfully
     */
    public function success()
    {
        $user = Auth::user();

        if (!$user->stripe_connect_account_id) {
            return redirect()->route('partner.bank_details.index')
                ->with('error', 'Stripe Connect account not found.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $account = Account::retrieve($user->stripe_connect_account_id);

        // Basic check: payouts enabled & charges enabled
        $payoutsEnabled = $account->payouts_enabled && $account->charges_enabled;

        $last4 = null;
        // Try to get last4 of bank account if available
        if (!empty($account->external_accounts) && $account->external_accounts->total_count > 0) {
            $bank = $account->external_accounts->data[0];
            if (!empty($bank->last4)) {
                $last4 = $bank->last4;
            }
        }

        $user->update([
            'payouts_enabled'     => $payoutsEnabled,
            'default_bank_last4'  => $last4,
        ]);

        if (!$payoutsEnabled) {
            return redirect()->route('partner.bank_details.index')
                ->with('error', 'Your account is created but payouts are not fully enabled yet. Stripe may still be verifying your details.');
        }

        return redirect()->route('partner.bank_details.index')
            ->with('success', 'Your payout bank details are set up successfully!');
    }
}
