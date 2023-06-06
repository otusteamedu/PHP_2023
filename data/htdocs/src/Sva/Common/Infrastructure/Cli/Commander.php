<?php

namespace Sva\Common\Infrastructure\Cli;

class Commander
{
    private array $commands = [];

    public function start(array $args = []): void
    {
        $action = 'default';

        if (isset($args[1])) {
            $action = $args[1];
        }

        $this->commands[$action]();
    }

    public function loadCommands(string $path): bool
    {
        if (file_exists($path)) {
            $this->commands = include $path;
        } else {
            return false;
        }

        return true;
    }
}
