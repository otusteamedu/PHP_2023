<?php

namespace Gkarman\Redis\Commands\Classes;

use Gkarman\Redis\Dto\EventDto;

class SaveEventCommand extends AbstractCommand
{
    public function run(): string
    {
        $event = $this->getEventByParams();
        if (!$event) {
            return 'событие не нашлось по данным параметрам';
        }

        $success = $this->repository->saveEvent($event);
        return $success ? 'true' : 'false';
    }

    private function getEventByParams(): ?EventDto
    {
        if (is_null($this->commandDto->param1)) {
            return null;
        }
        $allEventsSortedByPriority = $this->getAllEventsSortedByPriority();
        foreach ($allEventsSortedByPriority as $event) {
            $eventParam1 = $event['conditions']['param1'] ?? null;
            $eventParam2 = $event['conditions']['param2'] ?? null;

            $isEqualParams1 = !is_null($eventParam1) && $eventParam1 === $this->commandDto->param1;
            if (!$isEqualParams1) {
                continue;
            }

            if (!is_null($this->commandDto->param2)) {
                return new EventDto($event);
            }

            $isEqualParams2 = !is_null($eventParam2) && $eventParam2 === $this->commandDto->param2;

            if ($isEqualParams2) {
                return new EventDto($event);
            }
        }

        return null;
    }

    private function getAllEventsSortedByPriority(): array
    {
        $file = file_get_contents('src/Events/MainEvents.json');
        $events = json_decode($file, true);
        usort($events, function ($a, $b) {
            return $b['priority'] - $a['priority'];
        });
        return $events;
    }
}
