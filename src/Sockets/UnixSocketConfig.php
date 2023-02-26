<?php

declare(strict_types=1);

namespace Twent\Chat\Sockets;

use Exception;
use Twent\Chat\Core\Config;

final class UnixSocketConfig implements Config
{
    private array|false $data;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly string $path = __DIR__ . '/../../unix_socket.ini'
    ) {
        if (! file_exists($this->path)) {
            throw new Exception('config.ini не найден.');
        }

        $this->data = parse_ini_file($this->path);
    }

    public function get(string|int $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }
}
