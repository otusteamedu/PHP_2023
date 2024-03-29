<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Request;

class OrderCreateRequest
{
    public function __construct(
        public string $email,
        public string $comment,
    )
    {}
}
