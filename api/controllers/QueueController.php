<?php

namespace App\Controllers;

use App\Models\Request;
use Psr\Http\Message\ResponseInterface as Response;
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

        $requestModel = Request::create([
            'data' => $requestData,
            'status' => Request::STATUS_PENDING
        ]);

        Queue::push(new ProcessRequestJob($requestModel));

        return $response->withJson(['request_id' => $requestModel->id], 200);
    }
}
