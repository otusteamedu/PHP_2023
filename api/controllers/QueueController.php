<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Jobs\ProcessRequestJob;
use Illuminate\Support\Facades\Queue;

class QueueController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function addToQueue(Request $request, Response $response): Response
    {
        $requestData = $request->getParsedBody();

        Queue::push(new ProcessRequestJob($requestData));

        return $response->withJson(['message' => 'Request added to queue successfully'], 200);
    }
}
