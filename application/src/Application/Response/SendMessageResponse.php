<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Response;

use OpenApi\Attributes as OAT;

#[OAT\Schema]
class SendMessageResponse
{
    #[OAT\Property(
        property: 'messageId',
        description: 'Message id',
        type: 'string',
        example: '4b5475ea-c804-4e99-b7a5-fec918fd6e06'
    )]
    public function __construct(
        public readonly string $messageId
    ) {
    }

    public function toArray(): array
    {
        return [
            'messageId' => $this->messageId
        ];
    }
}
