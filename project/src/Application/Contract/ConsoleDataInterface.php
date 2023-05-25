<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Application\Dto\Output\ResultInit;

interface ConsoleDataInterface
{
    public function work(): void;
}
