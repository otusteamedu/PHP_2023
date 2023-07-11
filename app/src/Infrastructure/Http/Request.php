<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Http;

final class Request
{
    private array $data = [];

    public function __construct()
    {
        $input = file_get_contents('php://input');

        if (!empty($input)) {
            $this->data = json_decode($input, true, 512, JSON_THROW_ON_ERROR);
        }
    }

    public function get(string $key): mixed
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }
}
