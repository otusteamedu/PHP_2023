<?php

declare(strict_types=1);

namespace App\Rabbit\Interfaces;

interface ConfigInterface
{
    public function getHost(): string;

    public function getPort(): string;

    public function getUser(): string;

    public function getPassword(): string;
}
