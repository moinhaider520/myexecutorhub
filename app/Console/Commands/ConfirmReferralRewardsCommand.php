<?php

namespace App\Console\Commands;

use App\Mail\CustomEmail;
use App\Models\CustomerReferral;
use App\Models\CustomerWallet;
use App\Models\CustomerWalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConfirmReferralRewardsCommand extends Command
{
    protected $signature = 'referrals:confirm-pending';

    protected $description = 'Confirm matured pending customer referral rewards and move funds to available wallet balance';

    public function handle(): int
    {
        $pendingReferrals = CustomerReferral::query()
            ->with(['invite', 'referrer', 'referredUser'])
            ->where('status', 'pending')
            ->whereNotNull('pending_until')
            ->where('pending_until', '<=', now())
            ->get();

        if ($pendingReferrals->isEmpty()) {
            $this->info('No pending referral rewards are ready for confirmation.');

            return self::SUCCESS;
        }

        $confirmedCount = 0;

        foreach ($pendingReferrals as $referral) {
            DB::transaction(function () use ($referral, &$confirmedCount) {
                $wallet = CustomerWallet::firstOrCreate(
                    ['user_id' => $referral->referrer_user_id],
                    [
                        'available_balance' => 0,
                        'pending_balance' => 0,
                        'total_earned' => 0,
                        'total_withdrawn' => 0,
                    ]
                );

                $amount = (float) $referral->reward_amount;

                $wallet->decrement('pending_balance', $amount);
                $wallet->increment('available_balance', $amount);

                $referral->update([
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                ]);

                CustomerWalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'user_id' => $referral->referrer_user_id,
                    'type' => 'credit',
                    'category' => 'referral_reward_release',
                    'amount' => $amount,
                    'status' => 'completed',
                    'meta' => [
                        'referral_id' => $referral->id,
                        'released_from_pending' => true,
                    ],
                ]);

                if ($referral->invite) {
                    $referral->invite->update([
                        'status' => 'reward_confirmed',
                        'reward_confirmed_at' => now(),
                    ]);
                }

                $confirmedCount++;
            });

            $this->sendConfirmedRewardEmail($referral->fresh(['referrer', 'referredUser']));
        }

        $this->info("Confirmed {$confirmedCount} referral reward(s).");

        return self::SUCCESS;
    }

    protected function sendConfirmedRewardEmail(CustomerReferral $referral): void
    {
        $referrer = $referral->referrer;
        $referredUser = $referral->referredUser;

        if (!$referrer || !$referredUser) {
            return;
        }

        $message = "
            <h2>Hello {$referrer->name},</h2>
            <p>Your referral reward is now available.</p>
            <p><strong>£" . number_format((float) $referral->reward_amount, 2) . "</strong> from your referral of <strong>{$referredUser->name}</strong> has moved into your available wallet balance.</p>
            <p>You can now use it for purchases, upgrades, renewals, or withdraw it once your available wallet reaches the minimum threshold.</p>
            <p><a href='https://executorhub.co.uk/customer/referrals'>Open your referral dashboard</a></p>
            <p>Regards,<br>Executor Hub Team</p>
        ";

        try {
            Mail::to($referrer->email)->send(new CustomEmail(
                [
                    'subject' => 'Your Executor Hub referral reward is now available',
                    'message' => $message,
                ],
                'Your Executor Hub referral reward is now available'
            ));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
