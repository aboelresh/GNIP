<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIProvider implements AIProvider
{
    private string  $apiKey;
    private string  $model;
    private string  $baseUrl;
    private int     $timeout;

    public function __construct()
    {
        $this->apiKey  = config('gnip.ai.openai.api_key', '');
        $this->model   = config('gnip.ai.openai.model', 'gpt-4o-mini');
        $this->baseUrl = config('gnip.ai.openai.base_url', 'https://api.openai.com/v1');
        $this->timeout = config('gnip.ai.openai.timeout', 60);
    }

    public function complete(string $prompt, array $options = []): AIResponse
    {
        $startTime = microtime(true);

        try {
            $response = Http::timeout($this->timeout)
                ->withToken($this->apiKey)
                ->post("{$this->baseUrl}/chat/completions", [
                    'model'       => $this->model,
                    'messages'    => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => $options['temperature'] ?? 0.3,
                    'max_tokens'  => $options['max_tokens'] ?? 1000,
                ]);

            $duration = microtime(true) - $startTime;

            if (! $response->successful()) {
                return AIResponse::failure(
                    "HTTP {$response->status()}: {$response->body()}",
                    $this->getName(),
                    $this->model,
                );
            }

            $data    = $response->json();
            $content = trim($data['choices'][0]['message']['content'] ?? '');

            if (empty($content)) {
                return AIResponse::failure(
                    'Empty response from OpenAI',
                    $this->getName(),
                    $this->model,
                );
            }

            return AIResponse::success(
                content:          $content,
                provider:         $this->getName(),
                model:            $this->model,
                promptTokens:     $data['usage']['prompt_tokens'] ?? 0,
                completionTokens: $data['usage']['completion_tokens'] ?? 0,
                durationSeconds:  round($duration, 2),
            );

        } catch (\Exception $e) {
            Log::error('OpenAIProvider error: ' . $e->getMessage());

            return AIResponse::failure(
                $e->getMessage(),
                $this->getName(),
                $this->model,
            );
        }
    }

    public function isAvailable(): bool
    {
        return ! empty($this->apiKey);
    }

    public function getName(): string
    {
        return 'openai';
    }

    public function getModel(): string
    {
        return $this->model;
    }
}