<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Transfer;
use Illuminate\Support\Facades\Log;

class WeeklyPayoutCommand extends Command
{
    protected $signature = 'payouts:weekly';
    protected $description = 'Send commission payouts to partners via Stripe Connect';

    public function handle()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $partners = User::where('commission_amount', '>', 0)->get();

        foreach ($partners as $partner) {

            if (!$partner->stripe_connect_account_id) continue;
            if (!$partner->payouts_enabled) continue;

            $amount = intval($partner->commission_amount * 100);

            if ($amount < 1000) continue;

            try {
                $transfer = Transfer::create([
                    'amount'      => $amount,
                    'currency'    => 'gbp',
                    'destination' => $partner->stripe_connect_account_id,
                ]);

                $partner->payouts()->create([
                    'amount' => $amount / 100,
                    'stripe_transfer_id' => $transfer->id,
                    'type' => 'weekly',
                    'status' => 'sent'
                ]);

                $partner->update([
                    'commission_amount' => 0
                ]);

                Log::info("Transfer sent to partner {$partner->id} for £" . ($amount / 100));
            } catch (\Exception $e) {
                Log::error("Payout failed for partner {$partner->id}: " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
