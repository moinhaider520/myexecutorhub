<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OpenAI;
use App\Services\OpenAIKnowledgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class KnowledgeChatController extends Controller
{
    public function ask(Request $request, OpenAIKnowledgeService $knowledgeService)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $this->storeMessage('user', $validated['message']);

        try {
            $answer = $knowledgeService->answerQuestion($validated['message']);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'status' => 'error',
                'message' => 'I could not answer that right now. Please try again in a moment.',
            ], 500);
        }

        $this->storeMessage('assistant', $answer);

        return response()->json([
            'status' => 'success',
            'message' => $answer,
        ]);
    }

    private function storeMessage(string $role, string $content): void
    {
        if (!Auth::check()) {
            return;
        }

        OpenAI::create([
            'role' => $role,
            'content' => $content,
            'created_by' => Auth::id(),
        ]);
    }
}
