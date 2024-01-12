<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure\Controller;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\Request\SendMessageRequest;
use Gesparo\Homework\Application\Service\SendMessageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OAT;

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
    #[OAT\Post(
        path: '/requests',
        summary: 'Add new request for getting transactions by account number and date range',
        requestBody: new OAT\RequestBody(
            description: 'Request body',
            required: true,
            content: new OAT\MediaType(
                mediaType: 'form-data',
                schema: new OAT\Schema(
                    ref: 'components/schemas/SendMessageRequest'
                )
            )
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Request message id',
                content: new OAT\JsonContent(
                    ref: 'components/schemas/SendMessageResponse'
                )
            ),
        ]
    )]
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
