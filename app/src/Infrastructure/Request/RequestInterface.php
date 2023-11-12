<?php

namespace App\Infrastructure\Request;

interface RequestInterface
{
    public function toArray(): array;

    public function validate(): void;
}
