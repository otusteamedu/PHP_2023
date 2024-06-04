<?php

declare(strict_types=1);

namespace Propan13\App\Router;

class Route
{
    private ?string $commandName;

    public function __construct(string $commandName)
    {
        $this->commandName = $commandName;
    }

    public function getCommandName(): string
    {
        return $this->commandName;
    }
}
