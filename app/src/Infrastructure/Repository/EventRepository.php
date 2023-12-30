<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Event;
use App\Domain\ValueObject\Conditions;
use App\Domain\ValueObject\Exception\ConditionsParamNameNotValidException;
use App\Domain\ValueObject\Exception\ConditionsParamValueNotValidException;
use Ehann\RediSearch\AbstractIndex;

class EventRepository
{
    public function __construct(private readonly AbstractIndex $index)
    {
    }

    public function add(Event $event): void
    {
        $data = [];
        $data['name'] = $event->getName();
        $data['priority'] = $event->getPriority();
        $data = array_merge($data, $event->getConditions()->getParams());

        $this->index->add($data);
    }

    /**
     * @throws ConditionsParamNameNotValidException
     * @throws ConditionsParamValueNotValidException
     */
    public function get(Conditions $conditions): ?Event
    {
        $builder = $this->index->sortBy('priority', 'DESC');

        foreach ($conditions->getParams() as $k => $v) {
            $builder = $builder->numericFilter($k, $v, $v);
        }

        $result = $builder->search('', true);

        if (!empty($result->getDocuments()[0])) {
            $event = new Event();
            $conditions = [];

            foreach ($result->getDocuments()[0] as $key => $value) {
                if (str_starts_with($key, 'priority')) {
                    $event->setPriority($value);
                }

                if (str_starts_with($key, 'name')) {
                    $event->setName($value);
                }

                if (str_starts_with($key, 'param')) {
                    $conditions[$key] = $value;
                }
            }

            if (count($conditions) > 0) {
                $conditions = new Conditions($conditions);
                $event->setConditions($conditions);
            }

            return $event;
        }

        return null;
    }
}
