<?php

declare(strict_types=1);

namespace Gesparo\Homework\Controller;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Request\SendMessageRequest;
use Gesparo\Homework\Service\SendMessageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function __construct(
        private readonly SendMessageService $sendMessageService,
        private readonly Request $request
    )
    {
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function index(): Response
    {
        $request = new SendMessageRequest(
            $this->request->get('accountNumber'),
            $this->request->get('startDate'),
            $this->request->get('endDate')
        );

        $this->sendMessageService->send($request);

        return new JsonResponse(['status' => 'ok'], Response::HTTP_CREATED);
    }
}