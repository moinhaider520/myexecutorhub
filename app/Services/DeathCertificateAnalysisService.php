<?php

namespace App\Services;

use App\Exceptions\DuplicateDeathCertificateException;
use App\Models\DeathCertificateVerification;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Throwable;

class DeathCertificateAnalysisService
{
    private const DUPLICATE_BLOCKING_STATUSES = [
        'pending',
        'manual_review',
        'auto_verified',
        'approved_by_admin',
    ];

    public function __construct(
        private readonly ActivityLogger $activityLogger,
        private readonly DeathCertificatePythonApiService $pythonApiService
    ) {
    }

    public function analyze(DeathCertificateVerification $verification): DeathCertificateVerification
    {
        $verification->update([
            'processing_status' => 'processing',
            'hard_fail_reason' => null,
        ]);

        try {
            $response = $this->pythonApiService->analyze($verification);
        } catch (Throwable $exception) {
            $verification->update([
                'processing_status' => 'failed',
                'verification_status' => 'manual_review',
                'ocr_provider' => 'python_api_failed',
                'mismatch_reasons' => [$exception->getMessage()],
                'hard_fail_reason' => null,
            ]);

            $verification->customer->update([
                'death_verification_status' => 'pending_review',
            ]);

            $this->activityLogger->logManualActivity(
                customerId: $verification->customer_id,
                module: 'Death Certificate Verification',
                action: 'python_api_failed',
                subjectType: 'DeathCertificateVerification',
                subjectId: $verification->id,
                description: 'Death certificate analysis failed and was moved to manual review',
                meta: [
                    'error' => $exception->getMessage(),
                ],
            );

            return $verification->fresh(['document', 'customer', 'reviewActions']);
        }

        $documentChecks = $this->normalizeDocumentChecks(Arr::get($response, 'document_validation', []));
        $matchChecks = $this->normalizeMatchChecks(Arr::get($response, 'customer_matching', []), $verification);
        $fraudChecks = $this->mergeFraudChecks(
            Arr::get($response, 'duplicate_flags', []),
            $this->buildFraudChecks($verification)
        );
        $extracted = $this->normalizeExtractedData(Arr::get($response, 'extracted_data', []));
        $duplicateVerification = $this->findDuplicateVerificationByBdb($verification, Arr::get($extracted, 'bdb'));

        if ($duplicateVerification) {
            throw new DuplicateDeathCertificateException('Duplicate document. This document already exists.');
        }

        $mismatchReasons = $this->normalizeMismatchReasons(
            Arr::get($response, 'hard_fail_reasons', []),
            $documentChecks,
            $matchChecks,
            $fraudChecks,
            Arr::get($response, 'score_breakdown', [])
        );
        $hardFailReason = Arr::get($response, 'hard_fail_reason')
            ?: $this->firstReason(Arr::get($response, 'hard_fail_reasons', []))
            ?: $this->resolveHardFailReason($documentChecks, $matchChecks, $fraudChecks);
        $score = $this->resolveScore($response, $documentChecks, $matchChecks, $fraudChecks, $mismatchReasons);
        $status = $this->resolveVerificationStatus($response, $score, $hardFailReason);

        $verification->update([
            'processing_status' => 'completed',
            'verification_status' => $status,
            'analysis_version' => 'python_api_v1',
            'ocr_provider' => Arr::get($response, 'ocr_provider', 'python_api'),
            'ocr_raw_text' => Arr::get($response, 'ocr_text'),
            'ocr_confidence' => $this->normalizeConfidence(Arr::get($response, 'ocr_confidence')),
            'extracted_data' => $extracted,
            'normalized_data' => $extracted,
            'document_checks' => $documentChecks,
            'match_checks' => $matchChecks,
            'fraud_checks' => $fraudChecks,
            'mismatch_reasons' => $mismatchReasons,
            'confidence_score' => $score,
            'hard_fail_reason' => $hardFailReason,
            'bdb' => Arr::get($extracted, 'bdb'),
            'verified_at' => $status === 'auto_verified' ? now() : null,
            'verified_by' => $status === 'auto_verified' ? $verification->uploaded_by : null,
        ]);

        $customer = $verification->customer;
        $customerUpdate = match ($status) {
            'auto_verified' => [
                'death_verification_status' => 'verified',
                'date_of_death' => $this->normalizeDate(Arr::get($extracted, 'date_of_death')) ?? $customer->date_of_death,
                'deceased_verified_at' => now(),
            ],
            'manual_review' => [
                'death_verification_status' => 'pending_review',
            ],
            'rejected' => [
                'death_verification_status' => 'rejected',
            ],
            default => [],
        };

        if ($customerUpdate !== []) {
            $customer->update($customerUpdate);
        }

        $this->activityLogger->logManualActivity(
            customerId: $customer->id,
            module: 'Death Certificate Verification',
            action: $status,
            subjectType: 'DeathCertificateVerification',
            subjectId: $verification->id,
            description: 'Death certificate verification ' . str_replace('_', ' ', $status),
            meta: [
                'document_id' => $verification->document_id,
                'confidence_score' => $score,
                'hard_fail_reason' => $hardFailReason,
                'ocr_provider' => Arr::get($response, 'ocr_provider', 'python_api'),
                'verification_result' => Arr::get($response, 'verification_result'),
            ],
        );

        return $verification->fresh(['document', 'customer', 'reviewActions']);
    }

    private function normalizeExtractedData(array $fields): array
    {
        return [
            'bdb' => $this->normalizeString(Arr::get($fields, 'bdb')),
            'full_name' => $this->normalizeName(Arr::get($fields, 'full_name')),
            'previous_name' => $this->normalizeName(Arr::get($fields, 'previous_name', Arr::get($fields, 'previous_or_maiden_name'))),
            'date_of_death' => $this->normalizeDate(Arr::get($fields, 'date_of_death')),
            'date_of_birth' => $this->normalizeDate(Arr::get($fields, 'date_of_birth')),
            'place_of_death' => $this->normalizeString(Arr::get($fields, 'place_of_death')),
            'usual_address' => $this->normalizeString(Arr::get($fields, 'usual_address')),
            'occupation' => $this->normalizeString(Arr::get($fields, 'occupation')),
            'informant_name' => $this->normalizeName(Arr::get($fields, 'informant_name')),
            'informant_relationship' => $this->normalizeString(Arr::get($fields, 'informant_relationship')),
            'cause_of_death' => $this->normalizeString(Arr::get($fields, 'cause_of_death')),
            'registration_district' => $this->normalizeString(Arr::get($fields, 'registration_district')),
            'entry_number' => $this->normalizeString(Arr::get($fields, 'entry_number')),
        ];
    }

    private function normalizeDocumentChecks(array $checks): array
    {
        return [
            'structure_valid' => Arr::get($checks, 'layout_valid'),
            'required_sections_present' => empty(Arr::get($checks, 'missing_required_sections', [])),
            'text_readable' => Arr::get($checks, 'readable'),
            'manipulation_flag' => Arr::get($checks, 'manipulation_suspected'),
            'image_quality' => Arr::get($checks, 'image_quality'),
            'document_type' => Arr::get($checks, 'document_type'),
            'missing_required_sections' => Arr::get($checks, 'missing_required_sections', []),
            'certificate_age_check' => Arr::get($checks, 'certificate_age_check'),
            'has_readable_text' => Arr::get($checks, 'readable'),
        ];
    }

    private function normalizeMatchChecks(array $checks, DeathCertificateVerification $verification): array
    {
        $customer = $verification->customer;
        $nameLevel = Arr::get($checks, 'name_match.level');
        $addressLevel = Arr::get($checks, 'address_match.level');
        $occupationLevel = Arr::get($checks, 'occupation_match.level');
        $informantRelationshipLevel = Arr::get($checks, 'informant_relationship_match.level');

        return [
            'customer_name' => trim(($customer->name ?? '') . ' ' . ($customer->lastname ?? '')),
            'customer_date_of_birth' => $customer->date_of_birth?->format('Y-m-d'),
            'customer_address' => trim(implode(' ', array_filter([
                $customer->address,
                $customer->city,
                $customer->postal_code,
            ]))),
            'name_match_type' => $nameLevel,
            'name_similarity' => Arr::get($checks, 'name_match.score'),
            'name_match_reason' => Arr::get($checks, 'name_match.reason'),
            'name_exact_or_close' => in_array($nameLevel, ['exact', 'close', 'strong_positive'], true),
            'name_clearly_mismatch' => in_array($nameLevel, ['mismatch', 'strong_negative'], true),
            'previous_name_match_type' => Arr::get($checks, 'previous_name_match.level'),
            'previous_name_supports_match' => in_array(Arr::get($checks, 'previous_name_match.level'), ['exact', 'close', 'strong_positive'], true),
            'dob_match' => Arr::get($checks, 'dob_match'),
            'date_of_birth_matches' => Arr::get($checks, 'dob_match'),
            'date_of_birth_conflicts' => Arr::get($checks, 'dob_match') === false,
            'address_match_type' => $addressLevel,
            'address_similarity' => Arr::get($checks, 'address_match.score'),
            'address_match_reason' => Arr::get($checks, 'address_match.reason'),
            'address_close_match' => in_array($addressLevel, ['exact', 'close', 'medium_positive'], true),
            'occupation_match_type' => $occupationLevel,
            'occupation_match_reason' => Arr::get($checks, 'occupation_match.reason'),
            'informant_relationship_match_type' => $informantRelationshipLevel,
            'informant_relationship_match_reason' => Arr::get($checks, 'informant_relationship_match.reason'),
            'supporting_data_notes' => Arr::get($checks, 'supporting_data_notes'),
        ];
    }

    private function mergeFraudChecks(array $flags, array $localFraudChecks): array
    {
        return array_merge($localFraudChecks, [
            'duplicate_for_same_customer' => Arr::get($flags, 'is_duplicate', $localFraudChecks['duplicate_for_same_customer'] ?? false),
            'reused_for_other_customer' => Arr::get($flags, 'reused', $localFraudChecks['reused_for_other_customer'] ?? false),
            'duplicate_reason' => Arr::get($flags, 'reason'),
            'hard_fail' => Arr::get($flags, 'hard_fail', false),
        ]);
    }

    private function normalizeMismatchReasons(array $reasons, array $documentChecks, array $matchChecks, array $fraudChecks, array $scoreBreakdown = []): array
    {
        $reasons = array_values(array_filter(array_map(
            fn ($reason) => is_string($reason) && trim($reason) !== '' ? trim($reason) : null,
            $reasons
        )));

        if ($reasons !== []) {
            return array_values(array_unique(array_merge($reasons, $scoreBreakdown)));
        }

        $fallback = [];

        if (($documentChecks['structure_valid'] ?? true) === false) {
            $fallback[] = 'Invalid certificate structure';
        }

        if (($matchChecks['name_clearly_mismatch'] ?? false) === true) {
            $fallback[] = 'Name clearly does not match';
        }

        if (($matchChecks['date_of_birth_conflicts'] ?? false) === true) {
            $fallback[] = 'DOB clearly conflicts';
        }

        if (($fraudChecks['reused_for_other_customer'] ?? false) === true) {
            $fallback[] = 'Same document used for multiple customers';
        }

        return array_values(array_unique(array_merge($fallback, $scoreBreakdown)));
    }

    private function resolveHardFailReason(array $documentChecks, array $matchChecks, array $fraudChecks): ?string
    {
        if (($fraudChecks['reused_for_other_customer'] ?? false) === true) {
            return 'Same document used for multiple unrelated customers.';
        }

        if (($matchChecks['name_clearly_mismatch'] ?? false) === true) {
            return 'Name clearly does not match.';
        }

        if (($matchChecks['date_of_birth_conflicts'] ?? false) === true) {
            return 'DOB clearly conflicts.';
        }

        if (($documentChecks['structure_valid'] ?? true) === false) {
            return 'Invalid certificate structure.';
        }

        if (($documentChecks['image_quality'] ?? null) === 'poor' && ($documentChecks['text_readable'] ?? true) === false) {
            return 'Image quality too poor to verify core fields.';
        }

        return null;
    }

    private function resolveScore(array $response, array $documentChecks, array $matchChecks, array $fraudChecks, array $mismatchReasons): int
    {
        $score = Arr::get($response, 'confidence_score', Arr::get($response, 'score'));

        if (is_numeric($score)) {
            return max(0, min(100, (int) round((float) $score)));
        }

        $score = 0;

        if (($documentChecks['structure_valid'] ?? false) === true) {
            $score += 20;
        }
        if (($matchChecks['name_exact_or_close'] ?? false) === true) {
            $score += 30;
        }
        if (($matchChecks['date_of_birth_matches'] ?? false) === true) {
            $score += 30;
        }
        if (($matchChecks['address_close_match'] ?? false) === true) {
            $score += 15;
        }
        if (($fraudChecks['duplicate_for_same_customer'] ?? false) === true) {
            $score -= 10;
        }

        $score -= count($mismatchReasons) * 5;

        return max(0, min(100, $score));
    }

    private function resolveVerificationStatus(array $response, int $score, ?string $hardFailReason): string
    {
        $decision = Str::lower((string) Arr::get($response, 'verification_result', Arr::get($response, 'decision', '')));

        if ($hardFailReason !== null) {
            return 'rejected';
        }

        return match ($decision) {
            'auto_verify', 'auto-verify', 'auto_verified' => 'auto_verified',
            'manual_review', 'manual-review', 'review' => 'manual_review',
            'reject', 'rejected' => 'rejected',
            default => $score >= 85 ? 'auto_verified' : ($score >= 60 ? 'manual_review' : 'rejected'),
        };
    }

    private function buildFraudChecks(DeathCertificateVerification $verification): array
    {
        $sameBdbQuery = DeathCertificateVerification::query()
            ->where('id', '!=', $verification->id)
            ->whereNotNull('bdb')
            ->where('bdb', $verification->bdb)
            ->whereIn('verification_status', self::DUPLICATE_BLOCKING_STATUSES);

        $duplicateForCustomer = (clone $sameBdbQuery)
            ->where('customer_id', $verification->customer_id)
            ->exists();

        $otherCustomerVerification = (clone $sameBdbQuery)
            ->where('customer_id', '!=', $verification->customer_id)
            ->first();

        return [
            'duplicate_for_same_customer' => $duplicateForCustomer,
            'reused_for_other_customer' => $otherCustomerVerification !== null,
            'duplicate_other_customer_id' => $otherCustomerVerification?->customer_id,
            'duplicate_verification_id' => $otherCustomerVerification?->id,
        ];
    }

    private function findDuplicateVerificationByBdb(DeathCertificateVerification $verification, ?string $bdb): ?DeathCertificateVerification
    {
        if (!$bdb) {
            return null;
        }

        return DeathCertificateVerification::query()
            ->where('id', '!=', $verification->id)
            ->where('bdb', $bdb)
            ->whereIn('verification_status', self::DUPLICATE_BLOCKING_STATUSES)
            ->first();
    }

    private function normalizeName(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        return preg_replace('/\s+/', ' ', trim($value));
    }

    private function normalizeString(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        return preg_replace('/\s+/', ' ', trim($value));
    }

    private function normalizeDate(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (Throwable) {
            return null;
        }
    }

    private function normalizeConfidence($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_numeric($value)) {
            return null;
        }

        $float = (float) $value;

        if ($float <= 1) {
            $float *= 100;
        }

        return round(max(0, min(100, $float)), 2);
    }

    private function firstReason(array $reasons): ?string
    {
        foreach ($reasons as $reason) {
            if (is_string($reason) && trim($reason) !== '') {
                return trim($reason);
            }
        }

        return null;
    }
}
