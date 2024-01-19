<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Domain;

interface ISocketWriter
{
    public function write(string $value);
}