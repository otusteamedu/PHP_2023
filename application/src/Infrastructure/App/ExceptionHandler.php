<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\App;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ExceptionHandler
{
    public function handle(\Throwable $e): Response
    {
        if ($e instanceof ResourceNotFoundException) {
            return new Response('Page not Found', Response::HTTP_NOT_FOUND);
        }

        $responseMessage = <<<MESSAGE
            <h1>An error occurred</h1>
            <p>
                Message: {$e->getMessage()} 
                <br>
                <br>
                Trace:
                <pre>{$e->getTraceAsString()}</pre>
            </p>
            MESSAGE;

        return new Response($responseMessage, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
