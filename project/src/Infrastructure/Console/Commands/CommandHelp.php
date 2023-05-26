<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Infrastructure\Console\Contract\CommandInterface;

class CommandHelp implements CommandInterface
{
    private HelpDataInterface $helpData;

    public function __construct(HelpDataInterface $helpData)
    {
        $this->helpData = $helpData;
    }

    public function run(): void
    {
        $result = $this->helpData->help();
        fwrite(STDOUT, $result->getMessage() . PHP_EOL);
    }
}
