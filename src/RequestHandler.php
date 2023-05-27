<?php

declare(strict_types=1);

namespace Otus\App;

final readonly class RequestHandler
{
    public function __construct(
        private StringValidator $stringValidator,
    ) {
    }

    public function handle(): Response
    {
        [$httpCode, $responseText] = match (true) {
            !array_key_exists('string', $_POST) => [400, 'string param is required'],
            $this->stringValidator->isParenthesisValid($_POST['string']) => [200, 'You are good!'],
            default => [400, 'Incorrect string'],
        };

        return new Response($httpCode, $responseText);
    }
}
