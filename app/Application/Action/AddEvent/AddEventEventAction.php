<?php

namespace App\Application\Action\AddEvent;

use App\Application\Action\EventActionInterface;
use App\Application\Response\NullResponse;
use App\Application\Response\ResponseInterface;
use App\Domain\QueueElement;
use App\Infrastructure\RepositoryInterface;

class AddEventEventAction implements EventActionInterface
{
    private QueueElement $element;

    public function __construct(array $arguments)
    {
        $event = new QueueElement(
            $arguments[2],
            $arguments[3],
            $arguments[4],
            $arguments[5]
        );
        $this->element = $event;
    }

    public function do(RepositoryInterface $repository): ResponseInterface
    {
        $element = $this->element;

        $decoded = json_encode([
            $element->getPriorityValue(),
            $element->getConditionsParam1Value(),
            $element->getConditionsParam2Value(),
            $element->getEventValue()
        ]);

        $repository->addWithParams(
            $decoded,
            $element->getPriorityValue(),
            $element->getConditionsParam1Value(),
            $element->getConditionsParam2Value()
        );

        return NullResponse::make();
    }
}
