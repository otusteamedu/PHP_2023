<?php

declare(strict_types=1);

namespace App\After\Infrustructures\Command;

use Symfony\Component\Console\Command\Command;

abstract class CommandTemplateAbstract extends Command
{
    protected const SUCCESS_CODE = 0;
}
