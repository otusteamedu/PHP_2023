<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Http;

final class JsonResponse implements Response
{
    public function __construct(
        private readonly mixed $data,
        private readonly int $statusCode = 200,
    ) {
    }

    public function output()
    {
        http_response_code($this->statusCode);
        header('Content-type: application/json');
        echo json_encode($this->data);
    }
}
