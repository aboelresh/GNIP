<?php

namespace App\Services\AI;

use App\Models\AiLog;
use Illuminate\Support\Facades\Log;

class AIManager
{
    private array $providers = [];

    public function __construct()
    {
        $this->registerProviders();
    }

    private function registerProviders(): void
    {
        $order = config('gnip.ai.provider_order', ['ollama', 'openai']);

        $available = [
            'mse_proxy' => MseProxyProvider::class,
            'ollama' => OllamaProvider::class,
            'openai' => OpenAIProvider::class,
        ];

        foreach ($order as $name) {
            if (isset($available[$name])) {
                $this->providers[$name] = new $available[$name]();
            }
        }
    }

    public function complete(string $prompt, array $options = []): AIResponse
    {
        foreach ($this->providers as $name => $provider) {
            if (! $provider->isAvailable()) {
                Log::warning("AIManager: Provider [{$name}] not available, trying next.");

                continue;
            }

            $response = $provider->complete($prompt, $options);

            if ($response->success) {
                return $response;
            }

            Log::warning("AIManager: Provider [{$name}] failed: {$response->error}. Trying next.");
        }

        return AIResponse::failure(
            'All AI providers failed or unavailable.',
            'none',
            'none',
        );
    }

    public function completeAndLog(
        string $prompt,
        string $operation,
        mixed $subject = null,
        array $options = [],
    ): AIResponse {
        $response = $this->complete($prompt, $options);

        $logData = [
            'provider' => $response->provider,
            'model' => $response->model,
            'operation' => $operation,
            'status' => $response->success ? 'success' : 'failed',
            'prompt_tokens' => $response->promptTokens,
            'completion_tokens' => $response->completionTokens,
            'total_tokens' => $response->totalTokens(),
            'duration_seconds' => $response->durationSeconds,
            'error_message' => $response->error ?: null,
        ];

        if ($subject && method_exists($subject, 'aiLogs')) {
            $subject->aiLogs()->create($logData);
        } else {
            AiLog::create(array_merge($logData, [
                'subject_type' => 'none',
                'subject_id' => 0,
            ]));
        }

        return $response;
    }

    public function getAvailableProviders(): array
    {
        return collect($this->providers)
            ->filter(fn ($p) => $p->isAvailable())
            ->keys()
            ->toArray();
    }
}
