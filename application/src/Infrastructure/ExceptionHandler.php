<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure;

use Symfony\Component\HttpFoundation\Response;

class ExceptionHandler
{
    public function handle(\Throwable $e): Response
    {
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
