<?php

namespace App\Application\Action\GetFirstPrioritizedEvent;

use App\Application\Action\EventActionInterface;
use App\Application\ConditionDTO\ConditionParameterDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Infrastructure\RepositoryInterface;

class GetFirstPrioritizedEventAction implements EventActionInterface
{
    private ConditionParameterDTO $condition;

    public function __construct(array $arguments)
    {
        $this->condition = new ConditionParameterDTO(
            $arguments[2],
            $arguments[3]
        );
    }

    public function do(RepositoryInterface $repository): ResponseInterface
    {
        $response = $repository->getFirstPrioritized([
            'par1' => $this->condition->getParam1(),
            'par2' => $this->condition->getParam2()
        ]);

        return TheResponse::make($response);
    }
}
