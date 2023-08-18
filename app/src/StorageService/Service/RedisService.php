<?php

declare(strict_types=1);

namespace Neunet\App\StorageService\Service;

use Neunet\App\Models\Event;
use Predis\Client;
use RedisException;

class RedisService implements ServiceInterface
{
    private Client $redis;
    private string $eventPriorityKey = 'priority';
    private string $eventConditionsKey = 'conditions';

    public function __construct()
    {
        $this->redis = new Client([
            'host' => getenv('REDIS_HOST')
        ]);
    }

    /**
     * @throws RedisException
     */
    public function addEvent(Event $event): bool
    {
        if ($this->redis->lpush($this->eventPriorityKey, [$event->getPriority()])) {
            if (!$this->redis->lPush($this->eventConditionsKey, [json_encode($event->getConditions())])) {
                $this->redis->lPop($this->eventPriorityKey);
                throw new RedisException('Unable to add event');
            }
        }
        return true;
    }

    public function clearAllEvents(): bool
    {
        $this->redis->del([$this->eventPriorityKey, $this->eventConditionsKey]);
        return true;
    }

    public function getEvent(array $params): ?Event
    {
        $priorityArray = $this->redis->lRange($this->eventPriorityKey, 0, -1);
        $conditionsArray = $this->redis->lRange($this->eventConditionsKey, 0, -1);
        $event = null;

        for ($i = 0; $i < count($priorityArray); $i++) {
            $conditions = json_decode($conditionsArray[$i], true);
            $match = true;

            foreach ($conditions as $key => $param) {
                if (!$match || !isset($params[$key]) || $params[$key] !== $param) {
                    $match = false;
                }
            }

            if ($match) {
                if (isset($event) && $priorityArray[$i] >= $event->getPriority()) {
                    $event->setPriority((int)$priorityArray[$i]);
                    $event->setConditions($conditions);
                } elseif (!isset($event)) {
                    $event = new Event((int)$priorityArray[$i], $conditions);
                }
            }
        }

        if ($event->getPriority()) {
            return $event;
        }
        return null;
    }
}
