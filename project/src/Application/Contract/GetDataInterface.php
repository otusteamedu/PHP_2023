<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Infrastructure\Console\Result\ResultGet;

interface GetDataInterface
{
    public function get(string $employeeName): ResultGet;
}
