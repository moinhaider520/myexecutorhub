<?php

namespace App\Services;

use App\Models\KnowledgeSource;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class OpenAIKnowledgeService
{
    public function process(KnowledgeSource $source): KnowledgeSource
    {
        $source->update([
            'status' => 'processing',
            'error_message' => null,
        ]);

        try {
            $file = $this->uploadFile($source);
            $vectorStoreId = $this->resolveVectorStoreId();

            $source->update([
                'openai_file_id' => $file['id'],
                'openai_vector_store_id' => $vectorStoreId,
            ]);

            $vectorFile = $this->attachFileToVectorStore($vectorStoreId, $file['id']);

            $source->update([
                'status' => ($vectorFile['status'] ?? null) === 'completed' ? 'ready' : 'processing',
            ]);

            return $source->fresh();
        } catch (Throwable $exception) {
            $source->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);

            return $source->fresh();
        }
    }

    public function refreshStatus(KnowledgeSource $source): KnowledgeSource
    {
        if (!$source->openai_file_id || !$source->openai_vector_store_id) {
            return $source;
        }

        try {
            $response = $this->client()
                ->get("/vector_stores/{$source->openai_vector_store_id}/files/{$source->openai_file_id}")
                ->throw()
                ->json();

            $source->update([
                'status' => ($response['status'] ?? null) === 'completed' ? 'ready' : 'processing',
                'error_message' => $response['last_error']['message'] ?? null,
            ]);
        } catch (Throwable $exception) {
            $source->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
        }

        return $source->fresh();
    }

    public function answerQuestion(string $question): string
    {
        $vectorStoreIds = KnowledgeSource::query()
            ->where('status', 'ready')
            ->whereNotNull('openai_vector_store_id')
            ->pluck('openai_vector_store_id')
            ->unique()
            ->values()
            ->all();

        if ($vectorStoreIds === []) {
            return 'I do not have any approved knowledge base content ready yet. Please contact support for help.';
        }

        $response = $this->client()
            ->post('/responses', [
                'model' => config('services.openai.knowledge_model', 'gpt-4.1-mini'),
                'input' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the Executor Hub portal assistant. Answer only from the uploaded portal knowledge base where possible. Give short, practical, step-by-step guidance. If the knowledge base does not contain the answer, say that you could not find exact instructions and suggest contacting support.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $question,
                    ],
                ],
                'tools' => [
                    [
                        'type' => 'file_search',
                        'vector_store_ids' => $vectorStoreIds,
                        'max_num_results' => 5,
                    ],
                ],
                'temperature' => 0.2,
            ])
            ->throw()
            ->json();

        return $this->extractResponseText($response);
    }

    private function uploadFile(KnowledgeSource $source): array
    {
        $request = $this->client()->asMultipart();

        if ($source->type === 'pdf') {
            if (!$source->local_file_path || !Storage::disk('public')->exists($source->local_file_path)) {
                throw new RuntimeException('Knowledge source file is missing.');
            }

            $path = Storage::disk('public')->path($source->local_file_path);
            $request = $request->attach('file', fopen($path, 'r'), basename($path));
        } else {
            if (!trim((string) $source->content)) {
                throw new RuntimeException('Knowledge source text is empty.');
            }

            $request = $request->attach(
                'file',
                $source->content,
                str($source->title)->slug()->append('.txt')->toString()
            );
        }

        return $request
            ->post('/files', [
                'purpose' => 'assistants',
            ])
            ->throw()
            ->json();
    }

    private function attachFileToVectorStore(string $vectorStoreId, string $fileId): array
    {
        return $this->client()
            ->post("/vector_stores/{$vectorStoreId}/files", [
                'file_id' => $fileId,
            ])
            ->throw()
            ->json();
    }

    private function resolveVectorStoreId(): string
    {
        $configured = (string) config('services.openai.vector_store_id');

        if ($configured !== '') {
            return $configured;
        }

        $existing = KnowledgeSource::query()
            ->whereNotNull('openai_vector_store_id')
            ->latest()
            ->value('openai_vector_store_id');

        if ($existing) {
            return $existing;
        }

        $response = $this->client()
            ->post('/vector_stores', [
                'name' => config('app.name', 'Executor Hub') . ' Portal Knowledge Base',
            ])
            ->throw()
            ->json();

        return $response['id'] ?? throw new RuntimeException('OpenAI did not return a vector store id.');
    }

    private function client(): PendingRequest
    {
        $apiKey = (string) config('services.openai.key');

        if ($apiKey === '') {
            throw new RuntimeException('OpenAI API key is not configured.');
        }

        return Http::baseUrl((string) config('services.openai.base_url', 'https://api.openai.com/v1'))
            ->timeout((int) config('services.openai.timeout', 120))
            ->withToken($apiKey)
            ->acceptJson()
            ->withHeaders([
                'OpenAI-Beta' => 'assistants=v2',
            ]);
    }

    private function extractResponseText(array $response): string
    {
        if (isset($response['output_text']) && trim((string) $response['output_text']) !== '') {
            return trim((string) $response['output_text']);
        }

        $parts = [];

        foreach ($response['output'] ?? [] as $output) {
            foreach ($output['content'] ?? [] as $content) {
                if (($content['type'] ?? null) === 'output_text' && isset($content['text'])) {
                    $parts[] = $content['text'];
                }
            }
        }

        $text = trim(implode("\n", $parts));

        return $text !== ''
            ? $text
            : 'I could not generate an answer right now. Please try again in a moment.';
    }
}
