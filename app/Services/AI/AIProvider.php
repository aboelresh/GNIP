<?php

namespace App\Services\AI;

interface AIProvider
{
    public function complete(string $prompt, array $options = []): AIResponse;

    public function isAvailable(): bool;

    public function getName(): string;

    public function getModel(): string;
}
