<?php

namespace App\Application\Action\StatusUpdater;

use App\Domain\QueueElement;
use App\Infrastructure\GetterInterface;
use App\Infrastructure\Redis\Repository\RedisClientStatusRepository;

class StatusUpdater implements RunnableInterface
{
    private GetterInterface $cnf;

    public function __construct(GetterInterface $cnf)
    {
        $this->cnf = $cnf;
    }

    public function run(string $content): void
    {
        (new RedisClientStatusRepository($this->cnf))
            ->set((new QueueElement($content))->getUuid(), 'complete');
    }
}
