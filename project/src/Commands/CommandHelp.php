<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Services\Container;
use Vp\App\Services\Help;

class CommandHelp implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(array $argv): void
    {
        $help = Container::getInstance()->get(Help::class);
        $result = $help->work();
        fwrite(STDOUT, $result . PHP_EOL);
    }
}
