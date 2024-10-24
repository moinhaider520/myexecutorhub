<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OpenAI;

class OpenAIController extends Controller
{
    public function view()
    {
        try {
            $messages = OpenAI::where('created_by', Auth::id())->get();

            return response()->json([
                'status' => 'success',
                'data' => $messages
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve messages.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle chat requests to OpenAI API.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'content' => 'required|string',
        ]);

        try {
            // Make API request to OpenAI
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('OPENAI_API_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => $request->model,
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->content
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->json();

            // Save user's message
            OpenAI::create([
                'role' => 'user',
                'content' => $request->content,
                'created_by' => Auth::id()
            ]);

            if (isset($response['choices'][0]['message']['content'])) {
                // Save assistant's message
                OpenAI::create([
                    'role' => 'assistant',
                    'content' => $response['choices'][0]['message']['content'],
                    'created_by' => Auth::id()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => $response['choices'][0]['message']['content']
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid response from OpenAI API'
                ], 500);
            }

        } catch (Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
