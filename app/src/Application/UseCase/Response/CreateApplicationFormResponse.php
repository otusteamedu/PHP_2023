<?php

namespace App\Application\UseCase\Response;

class CreateApplicationFormResponse
{
    public function __construct(public readonly int $id, public readonly string $status)
    {
    }
}
