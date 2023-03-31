<?php
declare(strict_types=1);

namespace App\Socket;

use Socket;

interface SocketInterface
{
    public function create(int $domain, int $type, int $protocol = 0): Socket;

    public function connect(Socket $socket, string $address, ?int $port = null): void;

    public function write(Socket $socket, string $data, ?int $length = null): false|int;

    public function read(Socket $socket, int $length, int $mode = PHP_BINARY_READ): false|string;

    public function bind(Socket $socket, string $address, int $port = 0): void;

    public function listen(Socket $socket, int $backlog = 0): void;

    public function accept(Socket $socket): false|Socket;

    public function close(Socket $socket): void;
}