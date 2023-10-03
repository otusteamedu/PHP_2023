<?php

declare(strict_types=1);

namespace Eevstifeev\Hw12\Controllers;

use Eevstifeev\Hw12\Interfaces\StorageServiceInterface;

class EventsController
{
    public function __construct(readonly StorageServiceInterface $service)
    {
    }

    public function index(): void
    {
        echo 'Events';
    }

    public function add(): void
    {
        $conditions = $_REQUEST['conditions'] ?? [];
        $priority = $_REQUEST['priority'] ?? 0;
        $event = $_REQUEST['event'] ?? '';

        $data = [
            'conditions' => $conditions,
            'priority' => (int)$priority,
            'event' => $event,
        ];
        $event = $this->service->addEvent($data);
        echo 'Новое событие добавлено: ' . json_encode($event->toArray());
    }

    public function getByUuid(): void
    {
        $eventUuid = $_REQUEST['uuid'] ?? null;

        if ($eventUuid === null) {
            echo 'Не указан идентификатор события для редактирования.';
            return;
        }
        $event = $this->service->getEventByUuid($eventUuid);
        echo "Событие с идентификатором $eventUuid: " . json_encode($event->toArray());
    }

    public function clear(): void
    {
        $eventUuid = $_REQUEST['uuid'] ?? null;

        if ($eventUuid === null) {
            echo 'Не указан идентификатор события для удаления.';
            return;
        }
        $this->service->clearEvent($eventUuid);
        echo 'Событие с идентификатором ' . $eventUuid . ' было успешно удалено.';
    }

    public function clearAll(): void
    {
        $this->service->clearAllEvents();
        echo 'События очищены.';
    }

    public function find(): void
    {
        $params = $_REQUEST['params'];
        $event = $this->service->getEventByParams($params);
        if ($event === null) {
            echo 'Событие не найдено для указанных параметров.';
        } else {
            echo 'По вашему запросу: ' . json_encode($params) . ' найдено: ' . PHP_EOL;
            echo json_encode($event->toArray());
        }
    }
}
