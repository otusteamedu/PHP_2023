<?php

declare(strict_types=1);

namespace Twent\Hw12\Services;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\JsonSource;
use CuyZ\Valinor\Mapper\Tree\Message\Messages;
use CuyZ\Valinor\MapperBuilder;
use Redis;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twent\Hw12\DTO\Conditions;
use Twent\Hw12\Services\Contracts\EventManagerContract;
use Twent\Hw12\DTO\Event;

class EventManager implements EventManagerContract
{
    protected Redis $connect;

    public function __construct()
    {
        $this->connect = $this->initConnect();
    }

    private function initConnect(): Redis
    {
        $redis = new Redis();
        $redis->pconnect($_ENV['REDIS_MASTER_HOST'], (int) $_ENV['REDIS_PORT_NUMBER']);
        $redis->auth($_ENV['REDIS_PASSWORD']);
        $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
        //$redis->flushDB();

        return $redis;
    }

    public function create(Request $request): ?array
    {
        $data = $request->getContent();

        $event = $this->validate(new JsonSource($data), Event::class);

        return $this->save($event);
    }

    public function get(int $id): Event
    {
        return $this->findById($id);
    }

    public function findByConditions(Request $request)
    {
        $data = $request->getContent();

        $this->validate(new JsonSource($data), Conditions::class);

        $queryArray = json_decode($data, true);

        $keys = $this->connect->keys('conditions*');

        foreach ($keys as $key) {
            $rows = $this->connect->hGetAll($key);

            if ($queryArray === $rows) {
                $eventId = explode(':', $key)[2];

                return $this->findById(intval($eventId));
            }
        }
        // Кол-во элементов в множестве
        //dump($this->connect->)
        //dump($this->connect->zCard('priority'));
        // Место элемента в множестве
        //dump($this->connect->zRank('priority', 'event:1'));
        //$item = $this->connect->zRange('priority', 0, 10, true);
        //$key = array_flip($key);
        //dump(array_search($event->priority, $item));
        //dump($this->>connect->zCount('events', '1', '10'));
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
                $message = $message->withBody("Field {node_path} {original_message}<br>");
                echo $message;
            }
        }

        return $object ?? null;
    }

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

        $this->connect->zAdd('priority', ['NX'], $event->priority, "event:{$nextIndex}");

        return $eventData;
        // all keys for events
        //dump($this->connect->keys('event*'));
        // get data for event 1
        //dump($this->connect->hGetAll('event:1'));
        //dump($this->connect->hGetAll('conditions:event:1'));
    }

    public function findById(int $id): array
    {
        $iterator = null;
        $priority = $this->connect->zScan("priority", $iterator, "event:{$id}", 1);
        if ($priority) {
            $priority = intval($priority["event:{$id}"]);
        }

        $conditions = $this->connect->hGetAll("conditions:event:{$id}");
        $data = $this->connect->hGetAll("event:{$id}");

        if (!$priority || ! $conditions || ! $data) {
            throw new NotFoundHttpException('Событие не найдено!');
        }

        return compact('priority', 'conditions', 'data');
    }
}
