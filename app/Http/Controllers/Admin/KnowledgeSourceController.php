<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessKnowledgeSourceJob;
use App\Models\KnowledgeSource;
use App\Services\OpenAIKnowledgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KnowledgeSourceController extends Controller
{
    public function index()
    {
        $sources = KnowledgeSource::with('creator')
            ->latest()
            ->paginate(20);

        return view('admin.knowledge_sources.index', compact('sources'));
    }

    public function statusSnapshot(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn ($id) => (int) trim($id))
            ->filter()
            ->values();

        if ($ids->isEmpty()) {
            return response()->json([
                'sources' => [],
            ]);
        }

        $sources = KnowledgeSource::query()
            ->whereIn('id', $ids)
            ->get(['id', 'status', 'error_message', 'updated_at'])
            ->map(fn (KnowledgeSource $source) => [
                'id' => $source->id,
                'status' => $source->status,
                'error_message' => $source->error_message,
                'updated_at' => optional($source->updated_at)->toIso8601String(),
            ])
            ->values();

        return response()->json([
            'sources' => $sources,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:pdf,text',
            'file' => 'required_if:type,pdf|nullable|file|mimes:pdf|max:20480',
            'content' => 'required_if:type,text|nullable|string',
        ]);

        $path = null;
        if (($validated['type'] ?? null) === 'pdf' && $request->hasFile('file')) {
            $path = $request->file('file')->store('knowledge-sources', 'public');
        }

        $source = KnowledgeSource::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'local_file_path' => $path,
            'content' => $validated['type'] === 'text' ? $validated['content'] : null,
            'status' => 'pending',
            'created_by' => Auth::id(),
        ]);

        ProcessKnowledgeSourceJob::dispatch($source->id);

        return redirect()
            ->route('admin.knowledge_sources.index')
            ->with('success', 'Knowledge source uploaded. Background processing has started.');
    }

    public function refresh(KnowledgeSource $knowledgeSource, OpenAIKnowledgeService $knowledgeService)
    {
        $knowledgeService->refreshStatus($knowledgeSource);

        return redirect()
            ->route('admin.knowledge_sources.index')
            ->with('success', 'Knowledge source status refreshed.');
    }

    public function reprocess(KnowledgeSource $knowledgeSource)
    {
        $knowledgeSource->update([
            'status' => 'pending',
            'error_message' => null,
        ]);

        ProcessKnowledgeSourceJob::dispatch($knowledgeSource->id);

        return redirect()
            ->route('admin.knowledge_sources.index')
            ->with('success', 'Knowledge source reprocessing has started in background.');
    }

    public function destroy(KnowledgeSource $knowledgeSource)
    {
        if ($knowledgeSource->local_file_path) {
            Storage::disk('public')->delete($knowledgeSource->local_file_path);
        }

        $knowledgeSource->delete();

        return redirect()
            ->route('admin.knowledge_sources.index')
            ->with('success', 'Knowledge source deleted.');
    }
}
