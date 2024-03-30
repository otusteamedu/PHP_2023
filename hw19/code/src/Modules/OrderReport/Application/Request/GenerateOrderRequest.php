<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Application\Request;

class GenerateOrderRequest
{
    public function __construct(
        public string $emailTo,
        public string $createDateFrom,
        public string $createDateTo,
    ) {
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            $data['email_to'] ?? '',
            $data['create_date_from'] ?? '',
            $data['create_date_to'] ?? '',
        );
    }
}
