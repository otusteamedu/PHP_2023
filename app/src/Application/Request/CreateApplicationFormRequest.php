<?php

namespace App\Application\UseCase\Request;

class CreateApplicationFormRequest
{
    public function __construct(public readonly string $email, public readonly string $message)
    {
    }
}
