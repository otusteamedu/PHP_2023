<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure\Controller;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\Request\CheckFinishedMessageRequest;
use Gesparo\Homework\Application\Service\CheckFinishedMessageService;
use Gesparo\Homework\Infrastructure\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckController extends AbstractController
{
    private CheckFinishedMessageService $checkFinishedMessageService;

    public function __construct(Request $request, CheckFinishedMessageService $checkFinishedMessageService)
    {
        parent::__construct($request);

        $this->checkFinishedMessageService = $checkFinishedMessageService;
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function get(): Response
    {
        $request = new CheckFinishedMessageRequest(
            $this->request->get('messageId')
        );

        $response = $this->checkFinishedMessageService->check($request);

        return new JsonResponse($response->toArray(), Response::HTTP_OK);
    }
}
