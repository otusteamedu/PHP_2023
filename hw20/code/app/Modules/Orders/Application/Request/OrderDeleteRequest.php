<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Request;

class OrderDeleteRequest
{
    public function __construct(
        public string $uuid,
    )
    {}
}
