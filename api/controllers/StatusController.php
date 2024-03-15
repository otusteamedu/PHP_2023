<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Support\Facades\Queue;

class StatusController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getStatus(Request $request, Response $response, array $args): Response
    {
        $requestId = $args['requestId'];

        $status = Queue::connection()->getJobStatus($requestId);

        return $response->withJson(['status' => $status], 200);
    }
}
