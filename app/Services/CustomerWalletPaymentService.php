<?php

namespace App\Services;

use App\Mail\CustomEmail;
use App\Models\CustomerWallet;
use App\Models\CustomerWalletTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Stripe\Subscription;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CustomerWalletPaymentService
{
    public function payMonthlyRenewal(User $user, string $planName, float $amount, array $meta = []): CustomerWalletTransaction
    {
        return DB::transaction(function () use ($user, $planName, $amount, $meta) {
            $wallet = $this->getWallet($user);
            $this->assertSufficientAvailableBalance($wallet, $amount);

            $transaction = $this->debitWallet(
                $wallet,
                $user,
                $amount,
                'membership_renewal',
                array_merge($meta, [
                    'plan_name' => $planName,
                    'payment_flow' => 'wallet',
                ])
            );

            $user->update([
                'subscribed_package' => $planName,
                'trial_ends_at' => now()->addMonth(),
                'stripe_subscription_id' => null,
                'paypal_subscription_id' => null,
            ]);

            User::where('created_by', $user->id)->update([
                'subscribed_package' => $planName,
                'trial_ends_at' => now()->addMonth(),
            ]);

            return $transaction;
        });
    }

    public function payLifetimeUpgrade(User $user, string $planLabel, float $amount, array $meta = []): CustomerWalletTransaction
    {
        return DB::transaction(function () use ($user, $planLabel, $amount, $meta) {
            $wallet = $this->getWallet($user);
            $this->assertSufficientAvailableBalance($wallet, $amount);

            $priorStripeSubscriptionId = $user->stripe_subscription_id;
            $priorPaypalSubscriptionId = $user->paypal_subscription_id;

            $transaction = $this->debitWallet(
                $wallet,
                $user,
                $amount,
                'membership_upgrade',
                array_merge($meta, [
                    'plan_name' => $planLabel,
                    'payment_flow' => 'wallet',
                ])
            );

            $user->update([
                'subscribed_package' => $planLabel,
                'trial_ends_at' => now()->addYears(10),
                'stripe_subscription_id' => null,
                'paypal_subscription_id' => null,
            ]);

            User::where('created_by', $user->id)->update([
                'subscribed_package' => $planLabel,
                'trial_ends_at' => now()->addYears(10),
            ]);

            $this->cancelExternalSubscriptions($priorStripeSubscriptionId, $priorPaypalSubscriptionId);
            $this->sendLifetimeWalletEmail($user, $planLabel, $amount);

            return $transaction;
        });
    }

    protected function getWallet(User $user): CustomerWallet
    {
        return CustomerWallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'available_balance' => 0,
                'pending_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]
        );
    }

    protected function assertSufficientAvailableBalance(CustomerWallet $wallet, float $amount): void
    {
        if ((float) $wallet->available_balance < $amount) {
            throw new RuntimeException('Your available wallet balance does not cover this amount.');
        }
    }

    protected function debitWallet(
        CustomerWallet $wallet,
        User $user,
        float $amount,
        string $category,
        array $meta = []
    ): CustomerWalletTransaction {
        $wallet->decrement('available_balance', $amount);

        return CustomerWalletTransaction::create([
            'wallet_id' => $wallet->id,
            'user_id' => $user->id,
            'type' => 'debit',
            'category' => $category,
            'amount' => $amount,
            'status' => 'completed',
            'meta' => $meta,
        ]);
    }

    protected function cancelExternalSubscriptions(?string $stripeSubscriptionId, ?string $paypalSubscriptionId): void
    {
        if (!empty($stripeSubscriptionId)) {
            try {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $subscription = Subscription::retrieve($stripeSubscriptionId);
                $subscription->cancel();
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        if (!empty($paypalSubscriptionId)) {
            try {
                $provider = new PayPalClient();
                $provider->setApiCredentials(config('paypal'));
                $provider->getAccessToken();
                $provider->cancelSubscription($paypalSubscriptionId, 'Lifetime wallet upgrade');
            } catch (\Throwable $exception) {
                report($exception);
            }
        }
    }

    protected function sendLifetimeWalletEmail(User $user, string $planLabel, float $amount): void
    {
        $message = "
            <h2>Hello {$user->name},</h2>
            <p>Your wallet payment has been completed successfully.</p>
            <p>Your account is now on <strong>{$planLabel}</strong>.</p>
            <p>Wallet amount used: <strong>£" . number_format($amount, 2) . "</strong>.</p>
            <p><a href='https://executorhub.co.uk/customer/dashboard'>Access your dashboard</a></p>
            <p>Regards,<br>The Executor Hub Team</p>
        ";

        Mail::to($user->email)->send(new CustomEmail(
            [
                'subject' => 'Lifetime Upgrade Paid From Wallet - Executor Hub',
                'message' => $message,
            ],
            'Lifetime Upgrade Paid From Wallet'
        ));
    }
}
