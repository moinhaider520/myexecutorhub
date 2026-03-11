<?php

namespace App\Jobs;

use App\Mail\CustomEmail;
use App\Models\CustomerPartnerAccount;
use App\Models\User;
use App\Services\CpanelMailboxService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProvisionPartnerMailbox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $customerPartnerAccountId,
        public string $encryptedTemporaryPassword
    ) {
    }

    public function handle(CpanelMailboxService $mailboxService): void
    {
        $link = CustomerPartnerAccount::with(['customerUser', 'partnerUser'])->find($this->customerPartnerAccountId);

        if (!$link || !$link->customerUser || !$link->partnerUser) {
            return;
        }

        $temporaryPassword = Crypt::decryptString($this->encryptedTemporaryPassword);

        try {
            $provisionedMailbox = $this->provisionAvailableMailbox($link, $mailboxService, $temporaryPassword);
            $mailboxEmail = $provisionedMailbox['email'];
            $result = $provisionedMailbox['result'];

            $link->update([
                'mailbox_email' => $mailboxEmail,
                'provision_status' => 'active',
                'provisioned_at' => now(),
                'last_error' => null,
            ]);

            $link->partnerUser->update([
                'email' => $mailboxEmail,
                'status' => 'A',
            ]);

            $webmailUrl = $result['webmail_url'] ?: url('/login');
            $message = "
                <h2>Hello {$link->customerUser->name},</h2>
                <p>Your linked partner account is ready.</p>
                <p><strong>Partner login email:</strong> {$mailboxEmail}</p>
                <p><strong>Temporary password:</strong> {$temporaryPassword}</p>
                <p><strong>Dashboard login:</strong> <a href='" . route('login') . "'>" . route('login') . "</a></p>
                <p><strong>Webmail access:</strong> <a href='{$webmailUrl}'>{$webmailUrl}</a></p>
                <p>Please sign in and change the password as soon as possible.</p>
            ";

            Mail::to($link->customerUser->email)->send(new CustomEmail(
                [
                    'subject' => 'Your Executor Hub partner mailbox is ready',
                    'message' => $message,
                ],
                'Your Executor Hub partner mailbox is ready'
            ));
        } catch (\Throwable $exception) {
            $link->update([
                'provision_status' => 'failed',
                'last_error' => $exception->getMessage(),
            ]);

            $link->partnerUser->update([
                'status' => 'N',
            ]);

            Log::error('Partner mailbox provisioning failed.', [
                'customer_partner_account_id' => $link->id,
                'partner_user_id' => $link->partner_user_id,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    protected function provisionAvailableMailbox(
        CustomerPartnerAccount $link,
        CpanelMailboxService $mailboxService,
        string $temporaryPassword
    ): array {
        $domain = (string) config('services.cpanel.domain', 'executorhub.co.uk');
        $baseLocalPart = $link->requested_local_part ?: Str::before($link->mailbox_email, '@');
        $baseLocalPart = $baseLocalPart !== '' ? $baseLocalPart : 'partner';

        for ($attempt = 0; $attempt <= 20; $attempt++) {
            $localPart = $attempt === 0 ? $baseLocalPart : "{$baseLocalPart}.{$attempt}";
            $candidate = "{$localPart}@{$domain}";

            if ($this->emailIsUsedByAnotherUser($candidate, $link->partner_user_id)) {
                continue;
            }

            try {
                $result = $mailboxService->provisionMailbox($candidate, $temporaryPassword);

                return [
                    'email' => $candidate,
                    'result' => $result,
                ];
            } catch (\Throwable $exception) {
                if (!$this->isMailboxAlreadyExistsError($exception->getMessage())) {
                    throw $exception;
                }
            }
        }

        throw new \RuntimeException('Unable to find an available partner mailbox address.');
    }

    protected function emailIsUsedByAnotherUser(string $email, int $partnerUserId): bool
    {
        return User::where('email', $email)
            ->where('id', '!=', $partnerUserId)
            ->exists();
    }

    protected function isMailboxAlreadyExistsError(string $message): bool
    {
        $normalized = Str::lower($message);

        return Str::contains($normalized, [
            'already exists',
            'account already exists',
            'mailbox already exists',
        ]);
    }
}
