<?php

namespace src\infrastructure\log;

interface LogInterface
{
    public function info(string $message): void;

    public function warning(string $message): void;

    public function error(string $message): void;
}
