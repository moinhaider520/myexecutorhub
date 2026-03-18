<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\InvestmentAccount;
use App\Models\OnboardingProgress;
use App\Models\User;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class MoneyhubService
{
    protected string $clientId;
    protected string $redirectUri;
    protected string $identityBaseUrl;
    protected string $apiBaseUrl;
    protected string $privateKeyPath;
    protected string $authorizeScope;
    protected ?string $kid;

    public function __construct()
    {
        $config = config('services.moneyhub', []);

        $this->clientId = (string) ($config['client_id'] ?? '');
        $this->redirectUri = (string) ($config['redirect_uri'] ?? '');
        $this->identityBaseUrl = rtrim((string) ($config['identity_base_url'] ?? 'https://identity.moneyhub.co.uk'), '/');
        $this->apiBaseUrl = rtrim((string) ($config['api_base_url'] ?? 'https://api.moneyhub.co.uk/v3.0'), '/');
        $privateKeyPath = (string) ($config['private_key_path'] ?? '');
        $this->privateKeyPath = preg_match('/^[A-Za-z]:[\\\\\/]/', $privateKeyPath) || str_starts_with($privateKeyPath, DIRECTORY_SEPARATOR)
            ? $privateKeyPath
            : base_path($privateKeyPath);
        $this->authorizeScope = (string) ($config['authorize_scope'] ?? 'openid id:test offline_access accounts:read');
        $this->kid = $config['jwks_kid'] ?? null;
    }

    public function beginConnection(User $user): string
    {
        $this->ensureConfigured();

        $moneyhubUserId = $this->ensureMoneyhubUser($user);
        $state = Str::random(40);
        $nonce = Str::random(40);

        session([
            'moneyhub_auth' => [
                'state' => $state,
                'nonce' => $nonce,
                'app_user_id' => $user->id,
                'moneyhub_user_id' => $moneyhubUserId,
            ],
        ]);

        Log::info('Moneyhub connection started.', [
            'user_id' => $user->id,
            'moneyhub_user_id' => $moneyhubUserId,
            'redirect_uri' => $this->redirectUri,
        ]);

        $response = Http::asForm()
            ->acceptJson()
            ->post($this->oidcRequestEndpoint(), [
                'client_id' => $this->clientId,
                'redirect_uri' => $this->redirectUri,
                'response_type' => 'code id_token',
                'scope' => $this->authorizeScope,
                'nonce' => $nonce,
                'state' => $state,
                'prompt' => 'consent',
                'claims' => json_encode([
                    'id_token' => [
                        'sub' => [
                            'value' => $moneyhubUserId,
                            'essential' => true,
                        ],
                        'mh:con_id' => [
                            'essential' => true,
                        ],
                    ],
                ], JSON_UNESCAPED_SLASHES),
                'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                'client_assertion' => $this->buildClientAssertion($this->oidcRequestEndpoint()),
            ]);

        $this->throwIfFailed($response, 'Unable to start Moneyhub consent flow.');

        $requestUri = $response->json('requestUri') ?? $response->json('request_uri');

        if (!$requestUri) {
            throw new RuntimeException('Moneyhub did not return a request URI.');
        }

        return $this->oidcAuthorizeEndpoint() . '?' . http_build_query([
            'client_id' => $this->clientId,
            'request_uri' => $requestUri,
        ]);
    }

    public function completeConnection(User $user, string $code, string $state, ?string $idToken = null): array
    {
        $this->ensureConfigured();

        $authSession = session('moneyhub_auth');

        Log::info('Moneyhub callback received.', [
            'user_id' => $user->id,
            'state_present' => $state !== '',
            'code_present' => $code !== '',
            'id_token_present' => !empty($idToken),
            'session_present' => !empty($authSession),
        ]);

        if (!$authSession || (int) ($authSession['app_user_id'] ?? 0) !== (int) $user->id) {
            throw new RuntimeException('Your Moneyhub session has expired. Please try connecting the bank again.');
        }

        if (!hash_equals((string) $authSession['state'], $state)) {
            throw new RuntimeException('The Moneyhub callback state could not be verified.');
        }

        $tokenResponse = Http::asForm()
            ->acceptJson()
            ->post($this->tokenEndpoint(), [
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
                'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                'client_assertion' => $this->buildClientAssertion($this->tokenEndpoint()),
            ]);

        $this->throwIfFailed($tokenResponse, 'Moneyhub did not accept the callback code.');

        $tokenPayload = $tokenResponse->json();
        $tokenIdToken = $tokenPayload['id_token'] ?? $idToken;
        $connectionId = $this->extractConnectionId($tokenIdToken);

        $moneyhubUserId = (string) ($authSession['moneyhub_user_id'] ?? $user->moneyhub_user_id);
        $accounts = $this->fetchAccounts($moneyhubUserId);
        $stats = $this->syncAccounts($user, $accounts, $connectionId);

        Log::info('Moneyhub callback completed.', [
            'user_id' => $user->id,
            'moneyhub_user_id' => $moneyhubUserId,
            'connection_id' => $connectionId,
            'accounts_received' => count($accounts),
            'stats' => $stats,
        ]);

        session()->forget('moneyhub_auth');

        return $stats;
    }

    protected function ensureMoneyhubUser(User $user): string
    {
        if ($user->moneyhub_user_id) {
            return (string) $user->moneyhub_user_id;
        }

        $tokenResponse = Http::asForm()
            ->acceptJson()
            ->post($this->tokenEndpoint(), [
                'grant_type' => 'client_credentials',
                'scope' => 'user:create',
                'client_id' => $this->clientId,
                'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                'client_assertion' => $this->buildClientAssertion($this->tokenEndpoint()),
            ]);

        $this->throwIfFailed($tokenResponse, 'Unable to obtain a Moneyhub token for creating the customer record.');

        $accessToken = $tokenResponse->json('access_token');

        if (!$accessToken) {
            throw new RuntimeException('Moneyhub did not return an access token for user creation.');
        }

        $createUserResponse = Http::withToken($accessToken)
            ->acceptJson()
            ->post($this->identityBaseUrl . '/users', [
                'clientUserId' => (string) $user->id,
                'name' => $user->name ?: 'Executor Hub Customer ' . $user->id,
            ]);

        $this->throwIfFailed($createUserResponse, 'Unable to create the Moneyhub customer profile.');

        $moneyhubUserId = $createUserResponse->json('userId')
            ?? $createUserResponse->json('id')
            ?? Arr::get($createUserResponse->json(), 'data.userId')
            ?? Arr::get($createUserResponse->json(), 'data.id');

        if (!$moneyhubUserId) {
            throw new RuntimeException('Moneyhub did not return a user id for the customer.');
        }

        $user->forceFill([
            'moneyhub_user_id' => $moneyhubUserId,
            'moneyhub_user_created_at' => now(),
        ])->save();

        return (string) $moneyhubUserId;
    }

    protected function fetchAccounts(string $moneyhubUserId): array
    {
        $tokenResponse = Http::asForm()
            ->acceptJson()
            ->post($this->tokenEndpoint(), [
                'grant_type' => 'client_credentials',
                'scope' => 'accounts:read',
                'sub' => $moneyhubUserId,
                'client_id' => $this->clientId,
                'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                'client_assertion' => $this->buildClientAssertion($this->tokenEndpoint()),
            ]);

        $this->throwIfFailed($tokenResponse, 'Unable to obtain a Moneyhub token for reading accounts.');

        $accessToken = $tokenResponse->json('access_token');

        if (!$accessToken) {
            throw new RuntimeException('Moneyhub did not return an access token for account sync.');
        }

        $accountsResponse = Http::withToken($accessToken)
            ->acceptJson()
            ->get($this->apiBaseUrl . '/accounts');

        $this->throwIfFailed($accountsResponse, 'Unable to fetch Moneyhub account data.');

        $accounts = $accountsResponse->json();

        if (isset($accounts['accounts']) && is_array($accounts['accounts'])) {
            Log::info('Moneyhub accounts fetched.', [
                'moneyhub_user_id' => $moneyhubUserId,
                'result_count' => count($accounts['accounts']),
                'response_shape' => 'accounts',
            ]);

            return $accounts['accounts'];
        }

        if (isset($accounts['data']) && is_array($accounts['data'])) {
            Log::info('Moneyhub accounts fetched.', [
                'moneyhub_user_id' => $moneyhubUserId,
                'result_count' => count($accounts['data']),
                'response_shape' => 'data',
            ]);

            return $accounts['data'];
        }

        $result = is_array($accounts) ? array_values(array_filter($accounts, 'is_array')) : [];

        Log::info('Moneyhub accounts fetched.', [
            'moneyhub_user_id' => $moneyhubUserId,
            'result_count' => count($result),
            'response_shape' => 'root',
        ]);

        return $result;
    }

    protected function syncAccounts(User $user, array $accounts, ?string $connectionId): array
    {
        $stats = [
            'bank_accounts' => 0,
            'investment_accounts' => 0,
            'liabilities' => 0,
        ];

        DB::transaction(function () use ($accounts, $connectionId, $user, &$stats) {
            foreach ($accounts as $account) {
                if (!is_array($account)) {
                    Log::warning('Moneyhub sync skipped non-array account payload.', [
                        'user_id' => $user->id,
                        'account_payload_type' => gettype($account),
                    ]);
                    continue;
                }

                $accountId = $this->stringValue(
                    $account['id'] ?? null,
                    $account['accountId'] ?? null,
                    Arr::get($account, 'account.id'),
                );

                if (!$accountId) {
                    Log::warning('Moneyhub sync skipped account without identifier.', [
                        'user_id' => $user->id,
                        'account_keys' => array_keys($account),
                    ]);
                    continue;
                }

                $classification = $this->classifyAccount($account);
                $payload = json_encode($account, JSON_UNESCAPED_SLASHES);

                Log::info('Moneyhub syncing account.', [
                    'user_id' => $user->id,
                    'moneyhub_account_id' => $accountId,
                    'classification' => $classification,
                    'provider' => $this->providerName($account),
                    'account_name' => $this->stringValue(
                        $account['accountName'] ?? null,
                        $account['name'] ?? null,
                    ),
                ]);

                if ($classification === 'liability') {
                    DebtAndLiability::updateOrCreate(
                        ['moneyhub_account_id' => $accountId],
                        [
                            'debt_type' => $this->stringValue(
                                $account['accountType'] ?? null,
                                $account['type'] ?? null,
                                'Bank Liability'
                            ),
                            'reference_number' => $this->maskedReference($accountId, $account),
                            'loan_provider' => $this->providerName($account),
                            'contact_details' => $this->stringValue(
                                $account['accountName'] ?? null,
                                $account['name'] ?? null,
                                $this->providerName($account)
                            ),
                            'amount_outstanding' => $this->numericValue($account),
                            'created_by' => $user->id,
                            'source' => 'moneyhub',
                            'moneyhub_connection_id' => $connectionId,
                            'moneyhub_payload' => $payload,
                            'moneyhub_synced_at' => now(),
                        ]
                    );

                    $stats['liabilities']++;
                    continue;
                }

                if ($classification === 'investment') {
                    InvestmentAccount::updateOrCreate(
                        ['moneyhub_account_id' => $accountId],
                        [
                            'investment_type' => $this->stringValue(
                                $account['accountType'] ?? null,
                                $account['type'] ?? null,
                                'Investment'
                            ),
                            'company_name' => $this->providerName($account),
                            'account_number' => $this->maskedReference($accountId, $account),
                            'balance' => $this->numericValue($account),
                            'created_by' => $user->id,
                            'source' => 'moneyhub',
                            'moneyhub_connection_id' => $connectionId,
                            'moneyhub_payload' => $payload,
                            'moneyhub_synced_at' => now(),
                        ]
                    );

                    $stats['investment_accounts']++;
                    continue;
                }

                BankAccount::updateOrCreate(
                    ['moneyhub_account_id' => $accountId],
                    [
                        'account_type' => $this->stringValue(
                            $account['accountType'] ?? null,
                            $account['type'] ?? null,
                            'Bank Account'
                        ),
                        'bank_name' => $this->providerName($account),
                        'sort_code' => $this->extractSortCode($account),
                        'account_name' => $this->stringValue(
                            $account['accountName'] ?? null,
                            $account['name'] ?? null,
                            $this->providerName($account)
                        ),
                        'account_number' => $this->maskedReference($accountId, $account),
                        'balance' => $this->numericValue($account),
                        'created_by' => $user->id,
                        'source' => 'moneyhub',
                        'moneyhub_connection_id' => $connectionId,
                        'masked_account_number' => $this->maskedReference($accountId, $account),
                        'moneyhub_payload' => $payload,
                        'moneyhub_synced_at' => now(),
                    ]
                );

                $stats['bank_accounts']++;
            }

            if ($stats['bank_accounts'] > 0) {
                $progress = OnboardingProgress::firstOrCreate(
                    ['user_id' => $user->id],
                    ['bank_account_added' => true]
                );

                if (!$progress->bank_account_added) {
                    $progress->bank_account_added = true;
                    $progress->save();
                }
            }
        });

        return $stats;
    }

    protected function classifyAccount(array $account): string
    {
        $haystack = strtolower($this->stringValue(
            $account['accountType'] ?? null,
            $account['type'] ?? null,
            $account['accountSubType'] ?? null,
            $account['category'] ?? null,
            $account['name'] ?? null,
            $account['accountName'] ?? null,
        ));

        if (Str::contains($haystack, ['loan', 'credit', 'mortgage', 'debt', 'liability', 'card'])) {
            return 'liability';
        }

        if (Str::contains($haystack, ['investment', 'isa', 'share', 'stock', 'pension', 'portfolio', 'fund'])) {
            return 'investment';
        }

        return 'bank';
    }

    protected function providerName(array $account): string
    {
        return $this->stringValue(
            $account['providerName'] ?? null,
            Arr::get($account, 'provider.name'),
            Arr::get($account, 'connection.providerName'),
            'Connected Bank'
        );
    }

    protected function extractSortCode(array $account): string
    {
        $candidate = $this->stringValue(
            $account['sortCode'] ?? null,
            Arr::get($account, 'accountDetails.sortCode'),
            ''
        );

        return $candidate !== '' ? $candidate : 'N/A';
    }

    protected function numericValue(array $account): float
    {
        $value = $account['balance'] ?? null;

        if (is_array($value)) {
            $value = $value['amount'] ?? $value['current'] ?? $value['available'] ?? null;
        }

        if (is_array($value)) {
            if (isset($value['majorUnits']) || isset($value['minorUnits'])) {
                $majorUnits = (int) ($value['majorUnits'] ?? 0);
                $minorUnits = (int) ($value['minorUnits'] ?? 0);

                return round($majorUnits + ($minorUnits / 100), 2);
            }

            if (isset($value['value']) && is_numeric($value['value'])) {
                return round(((float) $value['value']) / 100, 2);
            }
        }

        $value = $this->stringValue(
            $value,
            $account['currentBalance'] ?? null,
            $account['availableBalance'] ?? null,
            Arr::get($account, 'balances.current'),
            Arr::get($account, 'balances.available'),
            0
        );

        return round((float) preg_replace('/[^0-9\.\-]/', '', (string) $value), 2);
    }

    protected function maskedReference(string $fallback, array $account): string
    {
        return $this->stringValue(
            $account['accountReference'] ?? null,
            $account['accountNumber'] ?? null,
            $account['maskedAccountNumber'] ?? null,
            Arr::get($account, 'accountDetails.accountNumber'),
            Arr::get($account, 'details.accountNumber'),
            '****' . substr(preg_replace('/\s+/', '', $fallback), -4)
        );
    }

    protected function buildClientAssertion(string $audience): string
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];

        if ($this->kid) {
            $header['kid'] = $this->kid;
        }

        $payload = [
            'iss' => $this->clientId,
            'sub' => $this->clientId,
            'aud' => $audience,
            'jti' => (string) Str::uuid(),
            'iat' => now()->timestamp,
            'exp' => now()->addMinutes(5)->timestamp,
        ];

        $segments = [
            $this->base64UrlEncode(json_encode($header, JSON_UNESCAPED_SLASHES)),
            $this->base64UrlEncode(json_encode($payload, JSON_UNESCAPED_SLASHES)),
        ];

        $privateKey = file_get_contents($this->privateKeyPath);

        if ($privateKey === false) {
            throw new RuntimeException('Unable to read the Moneyhub private key.');
        }

        $signature = '';
        $signResult = openssl_sign(implode('.', $segments), $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$signResult) {
            throw new RuntimeException('Unable to sign the Moneyhub client assertion.');
        }

        $segments[] = $this->base64UrlEncode($signature);

        return implode('.', $segments);
    }

    protected function extractConnectionId(?string $idToken): ?string
    {
        if (!$idToken || !str_contains($idToken, '.')) {
            return null;
        }

        $parts = explode('.', $idToken);
        $payload = json_decode($this->base64UrlDecode($parts[1] ?? ''), true);

        return $payload['mh:con_id'] ?? null;
    }

    protected function ensureConfigured(): void
    {
        if ($this->clientId === '') {
            throw new RuntimeException('Moneyhub client id is missing from configuration.');
        }

        if ($this->redirectUri === '') {
            throw new RuntimeException('Moneyhub redirect URI is missing from configuration.');
        }

        if ($this->privateKeyPath === '' || !is_file($this->privateKeyPath)) {
            throw new RuntimeException('Moneyhub private key file could not be found.');
        }
    }

    protected function oidcRequestEndpoint(): string
    {
        return $this->identityBaseUrl . '/oidc/request';
    }

    protected function oidcAuthorizeEndpoint(): string
    {
        return $this->identityBaseUrl . '/oidc/auth';
    }

    protected function tokenEndpoint(): string
    {
        return $this->identityBaseUrl . '/oidc/token';
    }

    protected function throwIfFailed($response, string $message): void
    {
        if ($response->successful()) {
            return;
        }

        try {
            $response->throw();
        } catch (RequestException $exception) {
            $detail = $response->json('error_description')
                ?? $response->json('message')
                ?? $response->body();

            Log::error('Moneyhub HTTP request failed.', [
                'message' => $message,
                'status' => $response->status(),
                'detail' => trim((string) $detail),
            ]);

            throw new RuntimeException($message . ' ' . trim((string) $detail), previous: $exception);
        }
    }

    protected function stringValue(...$values): string
    {
        foreach ($values as $value) {
            if ($value === null) {
                continue;
            }

            if (is_array($value)) {
                $value = implode(' ', $this->flattenToStrings($value));
            } elseif (is_object($value)) {
                if (method_exists($value, '__toString')) {
                    $value = (string) $value;
                } else {
                    $value = implode(' ', $this->flattenToStrings((array) $value));
                }
            }

            $value = trim((string) $value);

            if ($value !== '') {
                return $value;
            }
        }

        return '';
    }

    protected function flattenToStrings(array $values): array
    {
        $result = [];

        array_walk_recursive($values, function ($value) use (&$result) {
            if ($value === null) {
                return;
            }

            if (is_bool($value)) {
                $result[] = $value ? 'true' : 'false';
                return;
            }

            if (is_scalar($value)) {
                $string = trim((string) $value);

                if ($string !== '') {
                    $result[] = $string;
                }
            }
        });

        return $result;
    }

    protected function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    protected function base64UrlDecode(string $value): string
    {
        $padding = strlen($value) % 4;

        if ($padding > 0) {
            $value .= str_repeat('=', 4 - $padding);
        }

        return base64_decode(strtr($value, '-_', '+/')) ?: '';
    }
}
