<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MseProxyProvider implements AIProvider
{
    private string $baseUrl;
    private string $apiKey;
    private string $model;
    private int    $timeout;

    public function __construct()
    {
        $this->baseUrl = config('gnip.ai.mse_proxy.base_url', 'http://localhost:7777/v1');
        $this->apiKey  = config('gnip.ai.mse_proxy.api_key', 'change-secret-key-2026');
        $this->model   = config('gnip.ai.mse_proxy.model', 'gpt-4o-mini');
        $this->timeout = config('gnip.ai.mse_proxy.timeout', 120);
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
                    'Empty response from MSE Proxy',
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
            Log::error('MseProxyProvider error: ' . $e->getMessage());

            return AIResponse::failure(
                $e->getMessage(),
                $this->getName(),
                $this->model,
            );
        }
    }

    public function isAvailable(): bool
    {
        try {
            $response = Http::timeout(5)
                ->withToken($this->apiKey)
                ->get(str_replace('/v1', '', $this->baseUrl) . '/health');

            return $response->successful();
        } catch (\Exception $e) {
            // Try the completions endpoint directly
            try {
                $response = Http::timeout(5)
                    ->withToken($this->apiKey)
                    ->post("{$this->baseUrl}/chat/completions", [
                        'model'     => $this->model,
                        'messages'  => [['role' => 'user', 'content' => 'hi']],
                        'max_tokens'=> 5,
                    ]);
                return $response->successful();
            } catch (\Exception $e2) {
                return false;
            }
        }
    }

    public function getName(): string
    {
        return 'mse_proxy';
    }

    public function getModel(): string
    {
        return $this->model;
    }
}