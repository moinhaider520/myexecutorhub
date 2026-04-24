<?php

namespace App\Jobs;

use App\Models\KnowledgeSource;
use App\Services\OpenAIKnowledgeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessKnowledgeSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const DELAYS = [30, 60, 120, 300, 600, 900];

    public int $tries = 1;

    public function __construct(
        public int $knowledgeSourceId,
        public int $attemptNumber = 0
    ) {
    }

    public function handle(OpenAIKnowledgeService $knowledgeService): void
    {
        $source = KnowledgeSource::find($this->knowledgeSourceId);

        if (!$source) {
            return;
        }

        if ($source->status === 'ready' || $source->status === 'failed') {
            return;
        }

        if ($source->status === 'processing' && $source->openai_file_id && $source->openai_vector_store_id) {
            $source = $knowledgeService->refreshStatus($source);
        } else {
            $source = $knowledgeService->process($source);
        }

        if ($source->status === 'processing') {
            $nextAttempt = $this->attemptNumber + 1;
            $delayIndex = min($nextAttempt, count(self::DELAYS) - 1);

            self::dispatch($source->id, $nextAttempt)
                ->delay(now()->addSeconds(self::DELAYS[$delayIndex]));
        }
    }
}
