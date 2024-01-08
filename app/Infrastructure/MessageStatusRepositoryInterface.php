<?php

namespace App\Infrastructure;

interface MessageStatusRepositoryInterface
{
    public function get(string $key): string;

    public function set(string $uid, string $status): void;
}
