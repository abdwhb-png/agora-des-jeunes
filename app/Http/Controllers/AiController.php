<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AiController extends Controller
{
    protected $providers = [
        'openai' => [
            'url' => 'https://api.openai.com/v1/chat/completions',
            'key' => 'OPENAI_API_KEY',
            'headers' => ['Authorization' => 'Bearer'],
            'model' => 'gpt-4-turbo-preview',
        ],
        'groq' => [
            'url' => 'https://api.groq.com/openai/v1/chat/completions',
            'key' => 'GROQ_API_KEY',
            'headers' => ['Authorization' => 'Bearer'],
            'model' => 'mixtral-8x7b-32768',
        ],
        'gemini' => [
            'url' => 'https://generativelanguage.googleapis.com/v1/models/gemini-pro:streamGenerateContent',
            'key' => 'GEMINI_API_KEY',
            'headers' => ['x-goog-api-key' => ''],
            'model' => 'gemini-pro',
        ],
    ];

    public function chat(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'provider' => 'required|string|in:openai,groq,gemini',
            'messages' => 'required|array',
            'messages.*.role' => 'required|string|in:user,assistant,system',
            'messages.*.content' => 'required|string',
            'stream' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $provider = $this->providers[$request->provider];
        $apiKey = env($provider['key']);

        if (!$apiKey) {
            return response()->json([
                'error' => 'API key not configured for provider: ' . $request->provider
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Prepare headers
        $headers = array_merge(
            ['Content-Type' => 'application/json'],
            [$provider['headers'][0] => $provider['headers'][1] . $apiKey]
        );

        // Stream response if requested
        if ($request->input('stream', false)) {
            return $this->streamResponse($request, $provider, $headers);
        }

        // Regular response
        try {
            $response = Http::withHeaders($headers)
                ->post($provider['url'], [
                    'model' => $provider['model'],
                    'messages' => $request->messages,
                    'stream' => false,
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Provider API error',
                    'details' => $response->json()
                ], $response->status());
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Request failed',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function streamResponse(Request $request, array $provider, array $headers): StreamedResponse
    {
        return response()->stream(
            function () use ($request, $provider, $headers) {
                $client = Http::withHeaders($headers);

                try {
                    $response = $client->send('POST', $provider['url'], [
                        'json' => [
                            'model' => $provider['model'],
                            'messages' => $request->messages,
                            'stream' => true,
                        ]
                    ]);

                    foreach ($response->toPsrResponse()->getBody() as $chunk) {
                        if ($chunk !== "\n") {
                            echo $chunk;
                            ob_flush();
                            flush();
                        }
                    }
                } catch (\Exception $e) {
                    echo "data: {\"error\": \"" . $e->getMessage() . "\"}\n\n";
                    ob_flush();
                    flush();
                }
            },
            Response::HTTP_OK,
            [
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'X-Accel-Buffering' => 'no',
            ]
        );
    }
}
