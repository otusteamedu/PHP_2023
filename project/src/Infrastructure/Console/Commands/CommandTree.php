<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\TreeDataInterface;
use Vp\App\Infrastructure\Console\Contract\CommandInterface;

class CommandTree implements CommandInterface
{
    private TreeDataInterface $treeData;

    public function __construct(TreeDataInterface $treeData)
    {
        $this->treeData = $treeData;
    }

    public function run(): void
    {
        $result = $this->treeData->work();
        $tree = $result->getResult();

        foreach ($tree as $item) {
            fwrite(STDOUT, $item . PHP_EOL);
        }
    }
}
