<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Rabbit\Service;

use DEsaulenko\Hw19\Interfaces\ConsumerInterface;
use DEsaulenko\Hw19\Interfaces\ConsumerServiceInterface;

class ConsumerService implements ConsumerServiceInterface
{
    private ConsumerInterface $consumer;

    /**
     * @param ConsumerInterface $consumer
     */
    public function __construct(ConsumerInterface $consumer)
    {
        $this->consumer = $consumer;
    }

    public function consume(): void
    {
        $this->consumer->execute();
    }
}
