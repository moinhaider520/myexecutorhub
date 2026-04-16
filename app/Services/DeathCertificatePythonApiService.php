<?php

namespace App\Services;

use App\Models\DeathCertificateVerification;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class DeathCertificatePythonApiService
{
    public function analyze(DeathCertificateVerification $verification): array
    {
        $endpoint = (string) config('services.death_certificate_api.url');

        if ($endpoint === '') {
            throw new RuntimeException('Death certificate API URL is not configured.');
        }

        $payload = $this->buildPayload($verification);
        $fileUrl = $payload['file_url'] ?? null;
        $fileName = $payload['file_name'] ?? 'death_certificate';

        if (!$fileUrl) {
            throw new RuntimeException('Death certificate file URL is missing.');
        }

        $fileResponse = Http::timeout((int) config('services.death_certificate_api.timeout', 120))
            ->get($fileUrl);

        try {
            $fileResponse->throw();
        } catch (RequestException $exception) {
            throw new RuntimeException(
                'Unable to fetch uploaded death certificate file: ' . $exception->getMessage(),
                previous: $exception
            );
        }

        $request = Http::timeout((int) config('services.death_certificate_api.timeout', 120))
            ->acceptJson();

        $apiKey = (string) config('services.death_certificate_api.key');
        if ($apiKey !== '') {
            $request = $request->withToken($apiKey);
        }

        Log::info('Death certificate API request prepared.', [
            'verification_id' => $verification->id,
            'endpoint' => $endpoint,
            'file_url' => $payload['file_url'],
            'file_name' => $payload['file_name'],
            'mime_type' => $payload['mime_type'],
            'customer_reference' => $payload['customer_reference'],
        ]);

        $response = $request
            ->attach('file', $fileResponse->body(), $fileName)
            ->post($endpoint, [
                'file_url' => $payload['file_url'],
                'file_name' => $payload['file_name'],
                'mime_type' => $payload['mime_type'],
                'full_name' => $payload['customer_reference']['full_name'] ?? null,
                'date_of_birth' => $payload['customer_reference']['date_of_birth'] ?? null,
                'usual_address' => $payload['customer_reference']['usual_address'] ?? null,
                'city' => $payload['customer_reference']['city'] ?? null,
                'postal_code' => $payload['customer_reference']['postal_code'] ?? null,
                'occupation' => $payload['customer_reference']['occupation'] ?? null,
                'informant_relationship' => $payload['customer_reference']['informant_relationship'] ?? null,
            ]);

        Log::info('Death certificate API response received.', [
            'verification_id' => $verification->id,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        try {
            $response->throw();
        } catch (RequestException $exception) {
            Log::error('Death certificate API request failed.', [
                'verification_id' => $verification->id,
                'status' => $response->status(),
                'body' => $response->body(),
                'error' => $exception->getMessage(),
            ]);

            throw new RuntimeException(
                'Death certificate API request failed: ' . $exception->getMessage(),
                previous: $exception
            );
        }

        $decoded = $response->json();

        if (!is_array($decoded)) {
            throw new RuntimeException('Death certificate API returned an invalid JSON response.');
        }

        return $decoded;
    }

    public function buildPayload(DeathCertificateVerification $verification): array
    {
        $document = $verification->document;
        $customer = $verification->customer;
        $firstFile = $this->firstStoredFile($document?->file_path);

        return [
            'file_url' => $firstFile['url'] ?? null,
            'file_name' => $verification->uploaded_file_name,
            'mime_type' => $this->guessMimeType($verification->uploaded_file_name),
            'customer_reference' => [
                'full_name' => trim(($customer->name ?? '') . ' ' . ($customer->lastname ?? '')) ?: null,
                'date_of_birth' => $customer->date_of_birth?->format('Y-m-d') ?? null,
                'usual_address' => $customer->address,
                'city' => $customer->city,
                'postal_code' => $customer->postal_code,
                'occupation' => $customer->profession,
                'informant_relationship' => $customer->relationship,
            ],
        ];
    }

    private function firstStoredFile($storedFiles): array
    {
        if (is_string($storedFiles)) {
            $decoded = json_decode($storedFiles, true);
            $storedFiles = is_array($decoded) ? $decoded : [$storedFiles];
        }

        if (!is_array($storedFiles) || $storedFiles === []) {
            return [];
        }

        $first = $storedFiles[0];

        if (is_array($first)) {
            return $first;
        }

        return ['url' => $first];
    }

    private function guessMimeType(?string $fileName): ?string
    {
        if (!$fileName) {
            return null;
        }

        return match (Str::lower(pathinfo($fileName, PATHINFO_EXTENSION))) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            default => null,
        };
    }
}
