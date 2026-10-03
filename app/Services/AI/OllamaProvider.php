<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaProvider implements AIProvider
{
    private string $baseUrl;
    private string $model;
    private int    $timeout;

    public function __construct()
    {
        $this->baseUrl = config('gnip.ai.ollama.base_url', 'http://localhost:11434');
        $this->model   = config('gnip.ai.ollama.model', 'llama3.2');
        $this->timeout = config('gnip.ai.ollama.timeout', 120);
    }

    public function complete(string $prompt, array $options = []): AIResponse
    {
        $startTime = microtime(true);

        try {
            $response = Http::timeout($this->timeout)
                ->post("{$this->baseUrl}/api/generate", [
                    'model'  => $this->model,
                    'prompt' => $prompt,
                    'stream' => false,
                    'options' => [
                        'temperature' => $options['temperature'] ?? 0.3,
                        'num_predict' => $options['max_tokens'] ?? 1000,
                    ],
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
            $content = trim($data['response'] ?? '');

            if (empty($content)) {
                return AIResponse::failure(
                    'Empty response from Ollama',
                    $this->getName(),
                    $this->model,
                );
            }

            return AIResponse::success(
                content:          $content,
                provider:         $this->getName(),
                model:            $this->model,
                promptTokens:     $data['prompt_eval_count'] ?? 0,
                completionTokens: $data['eval_count'] ?? 0,
                durationSeconds:  round($duration, 2),
            );

        } catch (\Exception $e) {
            Log::error('OllamaProvider error: ' . $e->getMessage());

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
            $response = Http::timeout(5)->get("{$this->baseUrl}/api/tags");
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getName(): string
    {
        return 'ollama';
    }

    public function getModel(): string
    {
        return $this->model;
    }
}