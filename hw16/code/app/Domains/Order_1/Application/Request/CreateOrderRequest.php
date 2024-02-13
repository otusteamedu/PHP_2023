<?php

namespace App\Domains\Order_1\Application\Request;

class CreateOrderRequest
{
    public function __construct(
        public string $title,
        public string $description,
        public string $email,
    )
    {
    }

    public static function fromArray($args): self
    {
        $dto = new self(
            $args['title'],
            $args['description'],
            $args['email'],
        );
        return $dto;
    }
}
