<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Api;

class Config
{
    private ?string $apiKeyName;
    private ?string $apiToken;

    public function __construct(?string $apiKeyName, ?string $token)
    {
        $this->apiKeyName = $apiKeyName;
        $this->apiToken = $token;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function getApiKeyName(): ?string
    {
        return $this->apiKeyName;
    }
}
