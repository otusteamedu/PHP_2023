<?php

declare(strict_types=1);

namespace App\CliCommand;

use Symfony\Component\Console\Command\Command;

abstract class CommandTemplate extends Command
{
    protected const INDEX_NAME = 'otus-shop';

    protected const SUCCESS_CODE = 0;
}
