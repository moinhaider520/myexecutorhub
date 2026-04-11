<?php

namespace App\Console\Commands;

use App\Mail\CustomEmail;
use App\Models\CustomerReferralInvite;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReferralInviteRemindersCommand extends Command
{
    protected $signature = 'referrals:send-reminders';

    protected $description = 'Send reminder emails for referral invites nearing expiry';

    public function handle(): int
    {
        $windowStart = now()->addHours(24);
        $windowEnd = now()->addHours(48);

        CustomerReferralInvite::with('referrer')
            ->whereIn('status', ['sent', 'opened', 'activated'])
            ->whereNull('reminder_sent_at')
            ->whereNotNull('expires_at')
            ->whereBetween('expires_at', [$windowStart, $windowEnd])
            ->chunkById(100, function ($invites): void {
                foreach ($invites as $invite) {
                    $referrer = $invite->referrer;
                    if (!$referrer) {
                        continue;
                    }

                    $landingUrl = route('customer.referrals.accept', $invite->token);
                    $expiryText = $invite->expires_at?->format('j M Y, g:i A') ?? 'soon';
                    $roleLabel = $invite->invite_type === 'executor' ? 'executor' : 'adviser';

                    $message = "
                        <h2>Hello {$invite->name},</h2>
                        <p>This is a quick reminder that <strong>{$referrer->name}</strong> invited you to Executor Hub as an {$roleLabel}.</p>
                        <p>Your <strong>{$invite->discount_percent}% off</strong> referral offer expires on <strong>{$expiryText}</strong>.</p>
                        <p><a href='{$landingUrl}'>Open your invitation now</a></p>
                        <p>Activate your account before the offer expires to keep the discount attached to your first eligible purchase.</p>
                        <p>Regards,<br>Executor Hub Team</p>
                    ";

                    try {
                        Mail::to($invite->email)->send(new CustomEmail(
                            [
                                'subject' => 'Reminder: your Executor Hub referral offer expires soon',
                                'message' => $message,
                            ],
                            'Reminder: your Executor Hub referral offer expires soon'
                        ));
                    } catch (\Throwable $exception) {
                        report($exception);
                        $this->error("Reminder failed for invite #{$invite->id} ({$invite->email})");
                        continue;
                    }

                    $invite->forceFill([
                        'reminder_sent_at' => now(),
                    ])->save();

                    $this->info("Reminder sent for invite #{$invite->id} ({$invite->email})");
                }
            });

        CustomerReferralInvite::query()
            ->whereIn('status', ['sent', 'opened', 'activated'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        return self::SUCCESS;
    }
}
