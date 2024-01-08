<?php

namespace App\Application\Action\AddComboMessage;

use App\Application\Action\ActionInterface;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Domain\QueueElement;
use App\Infrastructure\MessageQueueRepositoryInterface;
use App\Infrastructure\MessageStatusRepositoryInterface;

class AddComboMessageAction implements ActionInterface
{
    private QueueElement $element;

    public function __construct(ArgumentsDTO $args)
    {
        $this->element = new QueueElement(
            $args->getFull()
        );
    }

    public function do(
        MessageQueueRepositoryInterface $repositoryQueue,
        MessageStatusRepositoryInterface $repositoryStatus
    ): ResponseInterface {
        $repositoryQueue->add($this->element->getBodyValue());
        $repositoryStatus->set($this->element->getUuid(), 'start');

        return TheResponse::createFromArray([
            'message' => 'Your request with be processed',
            'uuid' => $this->element->getUuid()
        ]);
    }
}
