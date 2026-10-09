<?php

namespace App\Services\AI;

class AIResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly string $content,
        public readonly string $provider,
        public readonly string $model,
        public readonly int $promptTokens = 0,
        public readonly int $completionTokens = 0,
        public readonly float $durationSeconds = 0,
        public readonly string $error = '',
    ) {
    }

    public static function success(
        string $content,
        string $provider,
        string $model,
        int $promptTokens = 0,
        int $completionTokens = 0,
        float $durationSeconds = 0,
    ): self {
        return new self(
            success: true,
            content: $content,
            provider: $provider,
            model: $model,
            promptTokens: $promptTokens,
            completionTokens: $completionTokens,
            durationSeconds: $durationSeconds,
        );
    }

    public static function failure(
        string $error,
        string $provider,
        string $model,
    ): self {
        return new self(
            success: false,
            content: '',
            provider: $provider,
            model: $model,
            error: $error,
        );
    }

    public function totalTokens(): int
    {
        return $this->promptTokens + $this->completionTokens;
    }
}
