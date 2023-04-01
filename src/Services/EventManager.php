<?php

declare(strict_types=1);

namespace Twent\Hw12\Services;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\JsonSource;
use CuyZ\Valinor\Mapper\Tree\Message\Messages;
use CuyZ\Valinor\MapperBuilder;
use InvalidArgumentException;
use Redis;
use RedisException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twent\Hw12\DTO\Conditions;
use Twent\Hw12\Services\Contracts\EventManagerContract;
use Twent\Hw12\DTO\Event;

class EventManager implements EventManagerContract
{
    protected Redis $connect;

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->connect = $this->initConnect();
    }

    /**
     * @throws RedisException
     */
    private function initConnect(): Redis
    {
        $redis = new Redis();
        $redis->pconnect($_ENV['REDIS_MASTER_HOST'], (int) $_ENV['REDIS_PORT_NUMBER']);
        $redis->auth($_ENV['REDIS_PASSWORD']);
        $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);

        return $redis;
    }

    /**
     * @throws RedisException
     */
    public function create(Request $request): ?array
    {
        $data = $request->getContent();

        $event = $this->validate(new JsonSource($data), Event::class);

        return $this->save($event);
    }

    /**
     * @throws RedisException
     */
    public function get(int $id): array
    {
        return $this->findById($id);
    }

    /**
     * @throws RedisException
     */
    public function findByConditions(Request $request): ?array
    {
        $data = $request->getContent();

        $this->validate(new JsonSource($data), Conditions::class);

        $queryArray = json_decode($data, true);

        $keys = $this->connect->keys('conditions*');

        $ids = [];

        // Search events ids contains conditions
        foreach ($keys as $key) {
            $rows = $this->connect->hGetAll($key);

            if ($queryArray === $rows) {
                $eventId = explode(':', $key)[2];

                $ids[] = $eventId;
            }
        }

        if (! $ids) {
            throw new NotFoundHttpException('Событие не найдено!');
        }

        return $this->findEventWithMaxPriority($ids);
    }

    private function validate(JsonSource $data, string $class): ?object
    {
        try {
            $object = (new MapperBuilder())
                ->supportDateFormats(
                    'd-m-Y H:i:s',
                    'Y-m-d H:i:s',
                    DATE_COOKIE,
                    DATE_RFC3339,
                    DATE_ATOM
                )
                ->mapper()
                ->map(
                    $class,
                    $data
                );
        } catch (MappingError $error) {
            $messages = Messages::flattenFromNode($error->node());

            foreach ($messages->errors() as $message) {
                $message = $message->withBody("Field {node_path} {original_message}");
                throw new InvalidArgumentException((string) $message);
            }
        }

        return $object ?? null;
    }

    /**
     * @throws RedisException
     */
    private function save(?Event $event): ?array
    {
        $eventData = toArray($event);

        $nextIndex = 1;
        $count = count($this->connect->keys('event*'));

        if ($count > 0) {
            $nextIndex = $count + 1;
        }

        $this->connect->hMSet("event:{$nextIndex}", $eventData['data']);

        $this->connect->hMSet("conditions:event:{$nextIndex}", $eventData['conditions']);

        $this->connect->zAdd('priority', $event->priority, "event:{$nextIndex}");

        return $eventData;
    }

    /**
     * @throws RedisException
     */
    public function findById($id): ?array
    {
        $priority = $this->getPriority($id);
        $conditions = $this->getConditions($id);
        $data = $this->getEventData($id);

        if (!$priority || ! $conditions || ! $data) {
            throw new NotFoundHttpException('Событие не найдено!');
        }

        return compact('priority', 'conditions', 'data');
    }

    /**
     * @throws RedisException
     */
    private function findEventWithMaxPriority(array $ids): ?array
    {
        $priorities = [];

        foreach ($ids as $id) {
            $priority = $this->getPriority($id);
            $priorities[$id] = $priority;
        }

        $maxPriority = max($priorities);
        $priorities = array_flip($priorities);

        $eventId = $priorities[$maxPriority];

        return $this->findById($eventId);
    }

    /**
     * @throws RedisException
     */
    private function getPriority($id): ?int
    {
        $iterator = null;
        $priority = $this->connect->zScan("priority", $iterator, "event:{$id}", 1);

        return $priority ? intval($priority["event:{$id}"]) : null;
    }

    /**
     * @throws RedisException
     */
    private function getConditions(int $id): ?array
    {
        return $this->connect->hGetAll("conditions:event:{$id}");
    }

    /**
     * @throws RedisException
     */
    private function getEventData(int $id): ?array
    {
        return $this->connect->hGetAll("event:{$id}");
    }
}
