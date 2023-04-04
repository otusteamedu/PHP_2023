<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Services\Container;
use Vp\App\Storage\Init;

class CommandInit implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(array $argv): void
    {
        $init = Container::getInstance()->get(Init::class);
        $result = $init->work();
        fwrite(STDOUT, $result . PHP_EOL);
    }
}
