<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OpenAI;

class OpenAIController extends Controller
{
    public function index()
    {
        $messages = OpenAI::where('created_by', Auth::id())->get();
        return view('customer.openai.view', compact('messages'));
    }

    public function chat(Request $request)
    {
        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('OPENAI_API_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => $request->post('model'),
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->post('content')
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->json();

            OpenAI::create([
                'role' => 'user',
                'content' => $request->post('content'),
                'created_by' => Auth::id()
            ]);

            if (isset($response)) {
                OpenAI::create([
                    'role' => 'assistant',
                    'content' => $response,
                    'created_by' => Auth::id()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => "Invalid API Request. Please Try Again."
                ]);

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid response from OpenAI API'
                ], 500);
            }

        } catch (Throwable $e) {
            // Log the error for debugging purposes
            \Log::error($e);

            return response()->json([
                'status' => 'error',
                'message' => 'Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.'
            ], 500);
        }
    }
}
