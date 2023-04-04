<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\DTO\ParamsAdd;
use Vp\App\Exceptions\CommandArguments;
use Vp\App\Services\Container;
use Vp\App\Storage\Add;

class CommandAdd implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws CommandArguments
     */
    public function run(array $argv): void
    {
        if (!isset($argv[2]) || !isset($argv[3])) {
            throw new CommandArguments('two required arguments expected');
        }

        $params = new ParamsAdd($argv[2], $argv[3]);

        $add = Container::getInstance()->get(Add::class);
        $result = $add->work($params);
        fwrite(STDOUT, $result . PHP_EOL);
    }
}
