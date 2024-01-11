<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Request;

use OpenApi\Attributes as OAT;

#[OAT\Schema]
class SendMessageRequest
{
    #[OAT\Property(
        property: 'accountNumber',
        description: 'Account number',
        type: 'string',
        maxLength: 16,
        minLength: 16,
        example: '1234567890123456',
        nullable: false
    )]
    #[OAT\Property(
        property: 'startDate',
        description: 'Start date',
        type: 'string',
        example: '2021-01-01',
        nullable: false
    )]
    #[OAT\Property(
        property: 'endDate',
        description: 'End date',
        type: 'string',
        example: '2022-01-01',
        nullable: false
    )]
    public function __construct(
        public ?string $accountNumber = null,
        public ?string $startDate = null,
        public ?string $endDate = null
    ) {
    }
}
