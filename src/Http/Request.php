<?php

declare(strict_types=1);

namespace App\Http;

readonly class Request implements RequestInterface
{
    public function __construct(
        public array $get,
        public array $post,
        public array $server
    )
    {}

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_SERVER);
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function input(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function body(): array
    {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }
}
