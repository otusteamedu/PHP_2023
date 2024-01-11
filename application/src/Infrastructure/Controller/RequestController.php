<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure\Controller;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\Request\SendMessageRequest;
use Gesparo\Homework\Application\Service\SendMessageService;
use Gesparo\Homework\Infrastructure\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestController extends AbstractController
{
    private SendMessageService $sendMessageService;

    public function __construct(Request $request, SendMessageService $sendMessageService)
    {
        parent::__construct($request);

        $this->sendMessageService = $sendMessageService;
    }

    /**
     * @return Response
     * @throws AppException
     */
    public function add(): Response
    {
        $request = new SendMessageRequest(
            $this->request->get('accountNumber'),
            $this->request->get('startDate'),
            $this->request->get('endDate')
        );

        $response = $this->sendMessageService->send($request);

        return new JsonResponse($response->toArray(), Response::HTTP_CREATED);
    }
}
