<?php

namespace App\Jobs;

use App\Mail\CustomEmail;
use App\Models\PartnerCustomerAccount;
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

class ProvisionLinkedCustomerMailbox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $partnerCustomerAccountId,
        public string $encryptedTemporaryPassword
    ) {
    }

    public function handle(CpanelMailboxService $mailboxService): void
    {
        $link = PartnerCustomerAccount::with(['partnerUser', 'customerUser'])->find($this->partnerCustomerAccountId);

        if (!$link || !$link->partnerUser || !$link->customerUser) {
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

            $link->customerUser->update([
                'email' => $mailboxEmail,
                'status' => 'A',
            ]);

            $webmailUrl = $result['webmail_url'] ?: url('/login');
            $message = "
                <h2>Hello {$link->partnerUser->name},</h2>
                <p>Your linked customer account is ready.</p>
                <p><strong>Customer dashboard email:</strong> {$mailboxEmail}</p>
                <p><strong>Temporary password:</strong> {$temporaryPassword}</p>
                <p><strong>Customer dashboard login:</strong> <a href='" . route('login') . "'>" . route('login') . "</a></p>
                <p><strong>Webmail access:</strong> <a href='{$webmailUrl}'>{$webmailUrl}</a></p>
                <p>This same mailbox login works for both webmail and the customer dashboard. Please change the password as soon as possible.</p>
            ";

            Mail::to($link->partnerUser->email)->send(new CustomEmail(
                [
                    'subject' => 'Your Executor Hub customer mailbox is ready',
                    'message' => $message,
                ],
                'Your Executor Hub customer mailbox is ready'
            ));
        } catch (\Throwable $exception) {
            $link->update([
                'provision_status' => 'failed',
                'last_error' => $exception->getMessage(),
            ]);

            $link->customerUser->update([
                'status' => 'N',
            ]);

            Log::error('Customer mailbox provisioning for partner self-purchase failed.', [
                'partner_customer_account_id' => $link->id,
                'customer_user_id' => $link->customer_user_id,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    protected function provisionAvailableMailbox(
        PartnerCustomerAccount $link,
        CpanelMailboxService $mailboxService,
        string $temporaryPassword
    ): array {
        $domain = (string) config('services.cpanel.domain', 'executorhub.co.uk');
        $baseLocalPart = $link->requested_local_part ?: Str::before($link->mailbox_email, '@');
        $baseLocalPart = $baseLocalPart !== '' ? $baseLocalPart : 'customer';

        for ($attempt = 0; $attempt <= 20; $attempt++) {
            $localPart = $attempt === 0 ? $baseLocalPart : "{$baseLocalPart}.{$attempt}";
            $candidate = "{$localPart}@{$domain}";

            if ($this->emailIsUsedByAnotherUser($candidate, $link->customer_user_id)) {
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

        throw new \RuntimeException('Unable to find an available customer mailbox address.');
    }

    protected function emailIsUsedByAnotherUser(string $email, int $customerUserId): bool
    {
        return User::where('email', $email)
            ->where('id', '!=', $customerUserId)
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
