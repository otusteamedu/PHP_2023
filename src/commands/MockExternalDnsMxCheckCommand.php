<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\commands;

use Ndybnov\Hw06\external\ValidateDnsMx;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MockExternalDnsMxCheckCommand
{
    public function run(Request $request, Response $response): Response
    {
        try {
            $queryParams = $request->getQueryParams();

            $strEmail = $queryParams['email'] ?? '';

            $isValidEmail = ValidateDnsMx::check($strEmail);
            $body = [
                'received' => $strEmail,
                'info' => $isValidEmail ? 'ok' : 'error',
            ];

            $response->getBody()->write(\json_encode($body, JSON_THROW_ON_ERROR));

            return $response->withStatus($isValidEmail ? 200 : 406);
        } catch (\Exception $exception) {
            throw new $exception($exception->getMessage());
        }
    }
}
