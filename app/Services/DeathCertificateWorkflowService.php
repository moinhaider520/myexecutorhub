<?php

namespace App\Services;

use App\Jobs\AnalyzeDeathCertificateJob;
use App\Models\DeathCertificateReviewAction;
use App\Models\DeathCertificateVerification;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeathCertificateWorkflowService
{
    public function __construct(
        private readonly ActivityLogger $activityLogger
    ) {
    }

    public function createForDocument(Document $document, int $customerId, int $uploadedBy, array $uploadMeta = []): ?DeathCertificateVerification
    {
        if (!$this->isDeathCertificate($document->document_type)) {
            return null;
        }

        return DB::transaction(function () use ($document, $customerId, $uploadedBy, $uploadMeta) {
            $verification = DeathCertificateVerification::updateOrCreate(
                ['document_id' => $document->id],
                [
                    'customer_id' => $customerId,
                    'uploaded_by' => $uploadedBy,
                    'processing_status' => 'queued',
                    'verification_status' => 'pending',
                    'document_sha256' => Arr::get($uploadMeta, 'document_sha256'),
                    'uploaded_file_name' => Arr::get($uploadMeta, 'uploaded_file_name'),
                    'uploaded_file_size' => Arr::get($uploadMeta, 'uploaded_file_size'),
                    'verified_at' => null,
                    'verified_by' => null,
                    'admin_notes' => null,
                ]
            );

            User::whereKey($customerId)->update([
                'death_verification_status' => 'pending_review',
            ]);

            $this->recordReviewAction($verification, 'submitted', 'pending', 'pending', 'Death certificate uploaded for analysis.', [
                'document_id' => $document->id,
            ]);

            $this->activityLogger->logManualActivity(
                customerId: $customerId,
                module: 'Death Certificate Verification',
                action: 'submitted',
                subjectType: 'DeathCertificateVerification',
                subjectId: $verification->id,
                description: 'Death certificate submitted for verification',
                meta: [
                    'document_id' => $document->id,
                    'uploaded_by' => $uploadedBy,
                ],
            );

            AnalyzeDeathCertificateJob::dispatchSync($verification->id);

            return $verification->fresh(['document', 'customer', 'reviewActions']);
        });
    }

    public function approve(DeathCertificateVerification $verification, array $overrideData = [], ?string $notes = null): DeathCertificateVerification
    {
        return DB::transaction(function () use ($verification, $overrideData, $notes) {
            $customer = $verification->customer;
            $normalizedData = array_merge($verification->normalized_data ?? [], $overrideData);
            $previousStatus = $verification->verification_status;

            $verification->update([
                'verification_status' => 'approved_by_admin',
                'processing_status' => 'completed',
                'normalized_data' => $normalizedData,
                'confidence_score' => max(85, (int) ($verification->confidence_score ?? 0)),
                'verified_at' => now(),
                'verified_by' => Auth::id(),
                'admin_notes' => $notes,
            ]);

            $customer->update([
                'death_verification_status' => 'verified',
                'date_of_death' => Arr::get($normalizedData, 'date_of_death') ?? $customer->date_of_death,
                'date_of_birth' => Arr::get($normalizedData, 'date_of_birth') ?? $customer->date_of_birth,
                'deceased_verified_at' => now(),
            ]);

            $this->recordReviewAction($verification, 'approved', $previousStatus, 'approved_by_admin', $notes, [
                'override_data' => $overrideData,
            ]);

            $this->activityLogger->logManualActivity(
                customerId: $customer->id,
                module: 'Death Certificate Verification',
                action: 'approved_by_admin',
                subjectType: 'DeathCertificateVerification',
                subjectId: $verification->id,
                description: 'Death certificate approved by admin',
                meta: [
                    'override_data' => $overrideData,
                ],
            );

            return $verification->fresh(['document', 'customer', 'reviewActions']);
        });
    }

    public function reject(DeathCertificateVerification $verification, ?string $notes = null): DeathCertificateVerification
    {
        return DB::transaction(function () use ($verification, $notes) {
            $previousStatus = $verification->verification_status;

            $verification->update([
                'verification_status' => 'rejected_by_admin',
                'processing_status' => 'completed',
                'verified_at' => null,
                'verified_by' => Auth::id(),
                'admin_notes' => $notes,
            ]);

            $verification->customer->update([
                'death_verification_status' => 'rejected',
            ]);

            $this->recordReviewAction($verification, 'rejected', $previousStatus, 'rejected_by_admin', $notes);

            $this->activityLogger->logManualActivity(
                customerId: $verification->customer_id,
                module: 'Death Certificate Verification',
                action: 'rejected_by_admin',
                subjectType: 'DeathCertificateVerification',
                subjectId: $verification->id,
                description: 'Death certificate rejected by admin',
                meta: [
                    'notes' => $notes,
                ],
            );

            return $verification->fresh(['document', 'customer', 'reviewActions']);
        });
    }

    public function reprocess(DeathCertificateVerification $verification, ?string $notes = null): DeathCertificateVerification
    {
        return DB::transaction(function () use ($verification, $notes) {
            $previousStatus = $verification->verification_status;

            $verification->update([
                'processing_status' => 'queued',
                'verification_status' => 'pending',
                'verified_at' => null,
                'verified_by' => null,
                'admin_notes' => $notes,
            ]);

            $verification->customer->update([
                'death_verification_status' => 'pending_review',
            ]);

            $this->recordReviewAction($verification, 'reprocessed', $previousStatus, 'pending', $notes);

            AnalyzeDeathCertificateJob::dispatchSync($verification->id);

            return $verification->fresh(['document', 'customer', 'reviewActions']);
        });
    }

    public function isDeathCertificate(?string $documentType): bool
    {
        $normalized = strtolower(trim((string) $documentType));

        return in_array($normalized, [
            'death certificate',
            'death_certificate',
            'death-certificate',
        ], true);
    }

    private function recordReviewAction(
        DeathCertificateVerification $verification,
        string $action,
        ?string $previousStatus,
        ?string $newStatus,
        ?string $notes = null,
        array $payload = []
    ): DeathCertificateReviewAction {
        return DeathCertificateReviewAction::create([
            'verification_id' => $verification->id,
            'actor_user_id' => Auth::id() ?? $verification->uploaded_by,
            'action' => $action,
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
            'payload' => $payload,
        ]);
    }
}
