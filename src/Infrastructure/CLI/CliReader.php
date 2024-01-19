<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Infrastructure\CLI;

use Kanakhin\WebSockets\Domain\ISocketReader;

class CliReader implements ISocketReader
{
    public function readLine(): string {
        echo "Введите сообщение: \n";
        return readline();
    }
}