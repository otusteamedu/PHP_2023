<?php

declare(strict_types=1);

namespace Khalikovdn\Hw12;

use Khalikovdn\Hw12\Interface\RedisStorageInterface;

class Event
{
    private RedisStorageInterface $redisStorageService;

    /**
     * @param RedisStorageInterface $redisStorageService
     */
    public function __construct(RedisStorageInterface $redisStorageService)
    {
        $this->redisStorageService = $redisStorageService;
        $this->loadEvents();
    }

    /**
     * @param array $query
     * @return string
     */
    public function getMostSuitableEvent(array $query): string
    {
        $matchingEvent = $this->redisStorageService->get($query);

        if ($matchingEvent) {
            return "Наиболее подходящее событие: " . json_encode($matchingEvent) . PHP_EOL;
        } else {
            return "Нет подходящих событий." . PHP_EOL;
        }
    }

    /**
     * @return void
     */
    public function loadEvents(): void
    {
        $this->redisStorageService->add(1000, ['param1' => 1], ['event' => '::event1::']);
        $this->redisStorageService->add(2000, ['param1' => 2, 'param2' => 2], ['event' => '::event2::']);
        $this->redisStorageService->add(3000, ['param1' => 1, 'param2' => 2], ['event' => '::event3::']);
    }
}