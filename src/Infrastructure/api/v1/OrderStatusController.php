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
use Symfony\Contracts\Cache\CacheInterface;

#[AsController]
#[Route('/api/v1/request/{uid}', methods: 'GET')]
final readonly class OrderStatusController
{
    public function __construct(
        private CacheInterface $cache
    ) {
    }

    public function __invoke(string $uid): Response
    {
        $message = $this->isConsumed($uid)
            ? 'Finished'
            : 'Your message is processing';

        return new Response($message);
    }

    private function isConsumed(string $uid): bool
    {
        return $this->cache->get($uid, static fn() => null) !== null;
    }
}
