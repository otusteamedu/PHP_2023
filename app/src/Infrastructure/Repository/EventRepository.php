<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Event;
use App\Domain\ValueObject\Conditions;
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

        //var_dump($data); die;

        $this->index->add($data);
    }

    public function get(Conditions $conditions): Event
    {
        $builder = $this->index->sortBy('priority', 'DESC');

        foreach ($conditions->getParams() as $k => $v) {
            $builder = $builder->numericFilter($k, $v, $v);
        }

        $result = $builder->search('', true);

        var_dump($result); die;
    }
}