<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\App;

use DEsaulenko\Hw19\Interfaces\ConsumerServiceInterface;

class ServerApp implements AppInterface
{
    private ConsumerServiceInterface $consumerService;

    /**
     * @param ConsumerServiceInterface $consumerService
     */
    public function __construct(ConsumerServiceInterface $consumerService)
    {
        $this->consumerService = $consumerService;
    }

    public function run(): void
    {
        $this->consumerService->consume();
    }
}
