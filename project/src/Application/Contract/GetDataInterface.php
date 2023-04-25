<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Application\Dto\Output\ResultGet;

interface GetDataInterface
{
    public function get(string $employeeName): ResultGet;
}
