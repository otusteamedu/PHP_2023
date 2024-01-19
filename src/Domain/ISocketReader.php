<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Domain;

interface ISocketReader
{
    public function readLine(): string;
}