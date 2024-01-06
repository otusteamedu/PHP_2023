<?php

namespace App\Application\Action\AddQueueMessage;

use App\Application\Action\ActionInterface;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Domain\QueueElement;
use App\Infrastructure\QueueRepositoryInterface;

class AddQueueMessageAction implements ActionInterface
{
    private QueueElement $element;

    public function __construct(ArgumentsDTO $args)
    {
        $this->element = new QueueElement(
            $args->getFull()
        );
    }

    public function do(QueueRepositoryInterface $repository): ResponseInterface
    {
        $repository->add(
            $this->element->getBodyValue()
        );

        return TheResponse::make('Your request will calc.');
    }
}
