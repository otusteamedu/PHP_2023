<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

class Settings
{
    private string $pathToSocket;
    private int $bufferSize;

    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        $filePath = __DIR__ . '/../config/config.ini';

        if (file_exists($filePath)) {
            $settings = parse_ini_file($filePath);
        } else {
            $settings = [];
        }

        $this->pathToSocket = $settings['SOCKET'] ?? '/tmp/brownchat.sock';
        $this->bufferSize = (int)($settings['BUFFER'] ?? 1024);
    }

    public function getPathToSocket(): string
    {
        return $this->pathToSocket;
    }

    public function getBufferSize(): int
    {
        return $this->bufferSize;
    }
}
