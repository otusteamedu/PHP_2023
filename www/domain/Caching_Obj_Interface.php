<?php

namespace src\domain;

interface Caching_Obj_Interface
{
    public function connect(string $host, int $port): bool;
    public function disconnect(): bool;
}
