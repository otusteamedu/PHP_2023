<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\InitDataInterface;
use Vp\App\Infrastructure\Console\Contract\CommandInterface;

class CommandInit implements CommandInterface
{
    private InitDataInterface $initData;

    public function __construct(InitDataInterface $initData)
    {
        $this->initData = $initData;
    }

    public function run(): void
    {
        $result = $this->initData->work();
        fwrite(STDOUT, $result . PHP_EOL);
    }
}
