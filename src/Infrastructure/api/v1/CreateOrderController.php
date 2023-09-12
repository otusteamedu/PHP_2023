<?php

declare(strict_types=1);

namespace App\Infrastructure\api\v1;

use App\Application\CreateOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;
use OpenApi\Attributes as OA;

/**
 * List the rewards of the specified user.
 *
 * This call takes into account all confirmed awards, but not pending or refused awards.
 */
#[AsController]
#[Route('/api/v1/request', methods: 'POST')]
#[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new OA\JsonContent(
        type: 'string',
    )
)]
final readonly class CreateOrderController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $ulid = new Ulid();

        $this->messageBus->dispatch(
            new CreateOrder($ulid, $request->getContent()),
            [new DelayStamp(random_int(5000, 10000))],
        );

        return new JsonResponse("You have successfully created request with id: {$ulid->toRfc4122()}");
    }
}
