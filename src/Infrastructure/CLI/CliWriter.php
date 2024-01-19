<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Infrastructure\CLI;

use Kanakhin\WebSockets\Domain\ISocketWriter;

class CliWriter implements ISocketWriter
{
    public function write($value)
    {
        echo $value . "\n";
    }
}