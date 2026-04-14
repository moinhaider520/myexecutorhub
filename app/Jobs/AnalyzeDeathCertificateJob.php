<?php

namespace App\Jobs;

use App\Models\DeathCertificateVerification;
use App\Services\DeathCertificateAnalysisService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AnalyzeDeathCertificateJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $verificationId
    ) {
    }

    public function handle(DeathCertificateAnalysisService $analysisService): void
    {
        $verification = DeathCertificateVerification::with(['document', 'customer'])->find($this->verificationId);

        if (!$verification) {
            return;
        }

        $analysisService->analyze($verification);
    }
}
