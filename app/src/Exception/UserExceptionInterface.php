<?php

declare(strict_types=1);

namespace App\Exception;

interface UserExceptionInterface
{
    public function getUserMessage(): string;
}