<?php

namespace App\Infrastructure\Response;

interface ResponseInterface
{
    public function toJson(): string;
}
