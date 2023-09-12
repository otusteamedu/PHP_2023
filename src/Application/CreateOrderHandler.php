<?php

declare(strict_types=1);

namespace App\Application;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\CacheInterface;

#[AsMessageHandler]
final readonly class CreateOrderHandler
{
    public function __construct(
        private CacheInterface $cache
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function __invoke(CreateOrder $message): void
    {
        $messageId = $message->getUlid()->toRfc4122();

        $this->cache->get($messageId, static fn() => $message->getBody());

        fwrite(STDOUT, "Message with id {$messageId} has consumed" . PHP_EOL);
    }
}
