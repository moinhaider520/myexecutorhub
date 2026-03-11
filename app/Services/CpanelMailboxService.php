<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class CpanelMailboxService
{
    public function provisionMailbox(string $email, string $password): array
    {
        $baseUrl = rtrim((string) config('services.cpanel.base_url'), '/');
        $username = (string) config('services.cpanel.username');
        $token = (string) config('services.cpanel.api_token');
        $accountUsername = (string) config('services.cpanel.account_username');
        $domain = (string) config('services.cpanel.domain');
        $quota = (int) config('services.cpanel.mailbox_quota_mb', 1024);

        if ($baseUrl === '' || $username === '' || $token === '' || $accountUsername === '' || $domain === '') {
            throw new RuntimeException('cPanel mailbox provisioning is not configured.');
        }

        [$localPart, $mailDomain] = explode('@', $email, 2);

        if ($mailDomain !== $domain) {
            throw new RuntimeException('The mailbox domain does not match the configured cPanel domain.');
        }

        $response = Http::withHeaders([
            'Authorization' => "whm {$username}:{$token}",
        ])->get("{$baseUrl}/json-api/cpanel", [
            'cpanel_jsonapi_user' => $accountUsername,
            'cpanel_jsonapi_apiversion' => 2,
            'cpanel_jsonapi_module' => 'Email',
            'cpanel_jsonapi_func' => 'addpop',
            'email' => $localPart,
            'domain' => $domain,
            'password' => $password,
            'quota' => $quota,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('cPanel request failed with HTTP status ' . $response->status() . '.');
        }

        $payload = $response->json();
        $status = (bool) (data_get($payload, 'cpanelresult.data.0.result')
            ?? data_get($payload, 'cpanelresult.event.result'));

        $errorMessage = data_get($payload, 'cpanelresult.error')
            ?? data_get($payload, 'cpanelresult.data.0.reason')
            ?? data_get($payload, 'cpanelresult.data.0.statusmsg');

        if (!$status) {
            throw new RuntimeException((string) ($errorMessage ?: 'cPanel mailbox provisioning failed.'));
        }

        return [
            'status' => 'active',
            'webmail_url' => (string) config('services.cpanel.webmail_url'),
            'raw_response' => $payload,
        ];
    }
}
