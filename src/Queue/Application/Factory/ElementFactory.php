<?php

declare(strict_types=1);

namespace src\Queue\Application\Factory;

use src\Queue\Application\UseCase\Request\AddElementQueueRequest;
use src\Queue\Domain\Entity\Element;

class ElementFactory implements ElementFactoryInterface
{
    public function fromAddElementQueueRequest(AddElementQueueRequest $request): Element
    {
        return new Element(
            uuid: sprintf('%s-%s', time(), 'uuid'),
            body: $request->getBody(),
            status: 'being checked'
        );
    }

    public function fromRedisResponse(array $response): Element
    {
        return new Element(
            uuid: $response['uuid'],
            body: $response['body'],
            status: $response['status']
        );
    }
}
