<?php

declare(strict_types=1);

namespace Twent\Chat\Sockets\Contracts;

use Socket;

interface SocketClientContract
{
    public static function getInstance(): static;
    public function getSocket(): ?Socket;
    public function connect(): ?bool;
    public function read(): ?string;
    public function write(string $data): ?int;
}
