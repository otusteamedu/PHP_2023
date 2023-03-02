<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Http;

final class Request
{
    public function __construct(
        private readonly array $parameters,
    ) {
    }

    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $this->parameters)) {
            return null;
        }

        return $this->parameters[$key];
    }
}
