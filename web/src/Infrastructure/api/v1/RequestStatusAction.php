<?php

declare(strict_types=1);

namespace src\Infrastructure\api\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('/api/v1/request/{ulid}', name: 'request_status', methods: ['GET'])]
class RequestStatusAction
{
    public function __construct(private CacheInterface $cache)
    {
    }

    public function __invoke(string $ulid): Response
    {
        $message = $this->cache->get($ulid, static fn() => null) ?
            'Finished' :
            'Processing';
        return new JsonResponse($message);
    }
}
