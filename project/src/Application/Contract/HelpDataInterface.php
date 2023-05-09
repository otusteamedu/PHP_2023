<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Application\Dto\Output\ResultHelp;

interface HelpDataInterface
{
    public function help(): ResultHelp;
}
