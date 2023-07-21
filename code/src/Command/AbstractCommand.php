<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic\Command;

use Timerkhanov\Elastic\Command\Interface\CommandInterface;

abstract class AbstractCommand implements CommandInterface
{
    protected array $args;

    public function __construct(array $args)
    {
        $this->args = $this->parse($args);
    }

    private function parse(array $args): array
    {
        $result = [];

        foreach ($args as $arg) {
            if (strpos($arg, '=') !== -1 && str_starts_with($arg, '--')) {
                $arg = explode('=', str_replace('--', '', $arg));

                $result[$arg[0]] = $arg[1] ?? '';
            }
        }

        return $result;
    }
}
