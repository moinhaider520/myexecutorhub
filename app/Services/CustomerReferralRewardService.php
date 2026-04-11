<?php

namespace App\Services;

use App\Mail\CustomEmail;
use App\Models\CustomerReferral;
use App\Models\CustomerReferralInvite;
use App\Models\CustomerWallet;
use App\Models\CustomerWalletTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CustomerReferralRewardService
{
    public function processSuccessfulPayment(
        User $referredUser,
        ?Request $request = null,
        ?string $paymentReference = null,
        float $rewardAmount = 25.0
    ): ?CustomerReferral {
        if (CustomerReferral::where('referred_user_id', $referredUser->id)->exists()) {
            return null;
        }

        $invite = $this->resolveInvite($referredUser);
        $referrer = $invite?->referrer;

        if (!$referrer && $request) {
            $referrerId = $request->session()->get('customer_referrer_user_id');
            if ($referrerId) {
                $referrer = User::find($referrerId);
            }
        }

        if (!$referrer) {
            return null;
        }

        if ($referrer->id === $referredUser->id || strcasecmp($referrer->email, $referredUser->email) === 0) {
            return $this->rejectReferral($referrer, $referredUser, $invite, $paymentReference, $rewardAmount, 'self_referral');
        }

        $rewardedCount = CustomerReferral::where('referrer_user_id', $referrer->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($rewardedCount >= 10) {
            return $this->rejectReferral($referrer, $referredUser, $invite, $paymentReference, $rewardAmount, 'reward_limit_reached');
        }

        $fraudReason = $this->detectFraudReason($referrer, $referredUser, $invite, $paymentReference);
        if ($fraudReason !== null) {
            return $this->rejectReferral($referrer, $referredUser, $invite, $paymentReference, $rewardAmount, $fraudReason);
        }

        $referral = DB::transaction(function () use ($invite, $referrer, $referredUser, $paymentReference, $rewardAmount) {
            $wallet = CustomerWallet::firstOrCreate(
                ['user_id' => $referrer->id],
                [
                    'available_balance' => 0,
                    'pending_balance' => 0,
                    'total_earned' => 0,
                    'total_withdrawn' => 0,
                ]
            );

            $pendingUntil = now()->addDays(14);

            $referral = CustomerReferral::create([
                'referrer_user_id' => $referrer->id,
                'referred_user_id' => $referredUser->id,
                'invite_id' => $invite?->id,
                'reward_amount' => $rewardAmount,
                'status' => 'pending',
                'pending_until' => $pendingUntil,
                'payment_reference' => $paymentReference,
            ]);

            $wallet->increment('pending_balance', $rewardAmount);
            $wallet->increment('total_earned', $rewardAmount);

            CustomerWalletTransaction::create([
                'wallet_id' => $wallet->id,
                'user_id' => $referrer->id,
                'type' => 'credit',
                'category' => 'referral_reward',
                'amount' => $rewardAmount,
                'status' => 'pending',
                'meta' => [
                    'referred_user_id' => $referredUser->id,
                    'invite_id' => $invite?->id,
                    'payment_reference' => $paymentReference,
                    'pending_until' => $pendingUntil->toDateTimeString(),
                ],
            ]);

            if ($invite) {
                $invite->update([
                    'status' => 'reward_pending',
                    'reward_pending_at' => now(),
                ]);
            }

            return $referral->fresh(['referrer', 'referredUser', 'invite']);
        });

        $this->sendPendingRewardEmail($referral);

        return $referral;
    }

    protected function resolveInvite(User $referredUser): ?CustomerReferralInvite
    {
        return CustomerReferralInvite::with('referrer')
            ->where(function ($query) use ($referredUser) {
                $query->where('invited_user_id', $referredUser->id)
                    ->orWhere('email', $referredUser->email);
            })
            ->whereIn('status', ['sent', 'opened', 'activated'])
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->orderByRaw("CASE WHEN status = 'activated' THEN 0 WHEN status = 'opened' THEN 1 ELSE 2 END")
            ->latest('id')
            ->first();
    }

    protected function detectFraudReason(
        User $referrer,
        User $referredUser,
        ?CustomerReferralInvite $invite,
        ?string $paymentReference
    ): ?string {
        if ($paymentReference && CustomerReferral::where('payment_reference', $paymentReference)->exists()) {
            return 'duplicate_payment_reference';
        }

        if ($invite) {
            $inviteClaimed = CustomerReferral::where('invite_id', $invite->id)
                ->where('referred_user_id', '!=', $referredUser->id)
                ->exists();

            if ($inviteClaimed) {
                return 'invite_already_rewarded';
            }

            if (strcasecmp($invite->email, $referredUser->email) !== 0) {
                return 'invite_email_mismatch';
            }
        }

        if (!empty($referrer->stripe_customer_id) && $referrer->stripe_customer_id === $referredUser->stripe_customer_id) {
            return 'shared_stripe_customer';
        }

        if (
            !empty($referrer->postal_code) &&
            !empty($referredUser->postal_code) &&
            !empty($referrer->country) &&
            !empty($referredUser->country) &&
            strcasecmp($referrer->postal_code, $referredUser->postal_code) === 0 &&
            strcasecmp($referrer->country, $referredUser->country) === 0 &&
            strcasecmp($referrer->name ?? '', $referredUser->name ?? '') === 0
        ) {
            return 'matching_contact_details';
        }

        return null;
    }

    protected function rejectReferral(
        User $referrer,
        User $referredUser,
        ?CustomerReferralInvite $invite,
        ?string $paymentReference,
        float $rewardAmount,
        string $reason
    ): CustomerReferral {
        $referral = CustomerReferral::create([
            'referrer_user_id' => $referrer->id,
            'referred_user_id' => $referredUser->id,
            'invite_id' => $invite?->id,
            'reward_amount' => $rewardAmount,
            'status' => 'rejected',
            'payment_reference' => $paymentReference,
            'rejection_reason' => $reason,
        ]);

        if ($invite && !in_array($invite->status, ['reward_pending', 'reward_confirmed'], true)) {
            $invite->update([
                'status' => 'rejected',
            ]);
        }

        return $referral;
    }

    protected function sendPendingRewardEmail(CustomerReferral $referral): void
    {
        $referrer = $referral->referrer;
        $referredUser = $referral->referredUser;

        if (!$referrer || !$referredUser) {
            return;
        }

        $message = "
            <h2>Hello {$referrer->name},</h2>
            <p>Your referral reward is now pending.</p>
            <p><strong>{$referredUser->name}</strong> completed a qualifying payment, so <strong>£" . number_format((float) $referral->reward_amount, 2) . "</strong> has been added to your pending wallet balance.</p>
            <p>Your reward will become available after <strong>{$referral->pending_until?->format('j M Y, g:i A')}</strong>, provided the payment remains valid.</p>
            <p><a href='https://executorhub.co.uk/customer/referrals'>View your referral dashboard</a></p>
            <p>Regards,<br>Executor Hub Team</p>
        ";

        try {
            Mail::to($referrer->email)->send(new CustomEmail(
                [
                    'subject' => 'Your Executor Hub referral reward is pending',
                    'message' => $message,
                ],
                'Your Executor Hub referral reward is pending'
            ));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
