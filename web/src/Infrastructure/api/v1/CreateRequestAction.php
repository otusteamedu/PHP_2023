<?php

declare(strict_types=1);

namespace src\Infrastructure\api\v1;

use src\Application\Service\UlidService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/request', name: 'create_request', methods: ['POST'])]
class CreateRequestAction
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(Request $request): Response
    {
        $ulid = UlidService::generate();

        $this->messageBus->dispatch(
            new Request($ulid, $request->getContent()),
            [new DelayStamp(5000)]
        );

        return new JsonResponse($ulid);
    }
}