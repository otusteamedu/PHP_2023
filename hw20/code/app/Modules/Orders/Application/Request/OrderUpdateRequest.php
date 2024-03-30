<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Request;

class OrderUpdateRequest
{
    public function __construct(
        public string $uuid,
        public string $email,
        public string $comment,
    )
    {}
}
