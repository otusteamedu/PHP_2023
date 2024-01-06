<?php

namespace App\Application\Action;

use App\Application\Response\ResponseInterface;
use App\Infrastructure\QueueRepositoryInterface;

interface ActionInterface
{
    public function do(QueueRepositoryInterface $repository): ResponseInterface;
}
