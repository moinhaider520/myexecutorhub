<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class BankStatementPythonApiService
{
    public function extract(UploadedFile $file): array
    {
        $endpoint = (string) config('services.bank_statement_api.url');
        $timeout = (int) config('services.bank_statement_api.timeout', 120);
        $fileContents = file_get_contents($file->getRealPath());

        if ($endpoint === '') {
            throw new RuntimeException('Bank statement API URL is not configured.');
        }

        $request = Http::timeout($timeout)
            ->retry(3, 2000, function ($exception, $request) {
                if (!$exception instanceof RequestException) {
                    return false;
                }

                $response = $exception->response;

                return $response instanceof Response
                    && in_array($response->status(), [429, 500, 502, 503, 504], true);
            }, throw: false)
            ->acceptJson();

        $apiKey = (string) config('services.bank_statement_api.key');
        if ($apiKey !== '') {
            $request = $request->withToken($apiKey);
        }

        Log::info('Bank statement API request prepared.', [
            'endpoint' => $endpoint,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        $response = $request
            ->attach(
                'file',
                $fileContents,
                $file->getClientOriginalName()
            )
            ->post($endpoint);

        Log::info('Bank statement API response received.', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        try {
            $response->throw();
        } catch (RequestException $exception) {
            $status = $response->status();

            if (in_array($status, [429, 500, 502, 503, 504], true)) {
                throw new RuntimeException($this->temporaryFailureMessage($response), previous: $exception);
            }

            throw new RuntimeException(
                'Bank statement API request failed: ' . $exception->getMessage(),
                previous: $exception
            );
        }

        $decoded = $response->json();

        if (!is_array($decoded)) {
            throw new RuntimeException('Bank statement API returned an invalid JSON response.');
        }

        if (!($decoded['success'] ?? false)) {
            throw new RuntimeException('Bank statement extraction was not successful.');
        }

        $extractedData = $decoded['extracted_data'] ?? null;

        if (!is_array($extractedData)) {
            throw new RuntimeException('Bank statement API response is missing extracted account data.');
        }

        return $extractedData;
    }

    private function temporaryFailureMessage(Response $response): string
    {
        $decoded = $response->json();
        $detail = is_array($decoded) ? ($decoded['detail'] ?? null) : null;
        $detail = is_string($detail) ? trim($detail) : '';

        if (stripos($detail, 'high demand') !== false || stripos($detail, 'unavailable') !== false) {
            return 'The bank statement extraction service is temporarily busy. Please try again in a few minutes.';
        }

        return 'The bank statement extraction service is temporarily unavailable. Please try again shortly.';
    }
}
