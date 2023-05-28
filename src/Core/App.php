<?php

declare(strict_types=1);

namespace Otus\App\Core;

use Otus\App\Http\Request;
use Otus\App\Http\RequestHandlerInterface;
use Otus\App\Http\Response;

final readonly class App
{
    public function __construct(
        private RequestHandlerInterface $requestHandler,
    ) {
    }

    public function run(): void
    {
        try {
            $request = $this->prepareRequest();
            $response = $this->requestHandler->handle($request);
        } catch (\Throwable $throwable) {
            $response = new Response(400, $throwable->getMessage());
        }

        $this->handleResponse($response);
    }

    private function prepareRequest(): Request
    {
        return new Request($_POST['string']);
    }

    private function handleResponse(Response $response): void
    {
        http_response_code($response->getHttpCode());
        echo $response->getHttpContent();
    }
}
