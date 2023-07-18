<?php

namespace Sva\Common\Infrastructure\Cli;

class Commander
{
    private array $commands = [];

    public function start(array $args = []): void
    {
        if (isset($args[1])) {
            $action = $args[1];
            if (array_key_exists($action, $this->commands)) {
                $arArgs = [];
                foreach (array_slice($args, 2) as $key => $value) {
                    $value = explode("=", $value);
                    $arArgs[$value[0]] = $value[1];
                }

                $this->commands[$action]($arArgs);
            } else {
                echo "Command not found\n";
            }
        }
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
