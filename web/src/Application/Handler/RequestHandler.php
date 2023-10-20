<?php

declare(strict_types=1);

namespace src\Application\Handler;

use src\Domain\Model\Request;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\CacheInterface;

#[AsMessageHandler]
class RequestHandler
{
    public function __construct(private readonly CacheInterface $cache)
    {
    }

    public function __invoke(Request $message): void
    {
        $messageId = $message->getUlid();
        $this->cache->get($messageId, static fn() => $message->getBody());
        fwrite(STDOUT, "Message with id {$messageId} has consumed" . PHP_EOL);
    }
}
