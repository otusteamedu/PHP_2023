<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\DTO\SearchParams;
use Vp\App\Services\Container;
use Vp\App\Storage\Search;

class CommandSearch implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(?array $argv): void
    {
        $searchParams = new SearchParams($argv[2] ?? null, $argv[3] ?? null, $argv[4] ?? null);
        $search = Container::getInstance()->get(Search::class);
        $result = $search->work($searchParams);
        $result->print();
    }
}
