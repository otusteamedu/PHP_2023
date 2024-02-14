<?php

declare(strict_types=1);

namespace src\Queue\Application\Factory;

use src\Queue\Application\UseCase\Request\AddElementQueueRequest;

interface ElementFactoryInterface
{
    public function fromAddElementQueueRequest(AddElementQueueRequest $request);
}
