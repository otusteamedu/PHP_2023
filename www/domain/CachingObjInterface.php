<?php

namespace src\domain;

interface CachingObjInterface
{
    public function connect(string $host, int $port): bool;
    public function disconnect(): bool;
}
