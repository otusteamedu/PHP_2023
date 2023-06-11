<?php

declare(strict_types=1);

namespace App\Transport\Socket;

use Socket as SocketNative;

interface SocketInterface
{
    public function create(bool $reWriteFile): static;

    public function bind(): static;

    public function connect(): static;

    public function listen(int $backlog);

    public function accept(): SocketNative|false;

    public function write(string $message, ?int $length): int|false;

    public function send(SocketNative $socket, string $message, int $length = null): int|false;

    public function read(): string;

    public function recv(SocketNative $socket): string|null;

    public function close(): static;
}