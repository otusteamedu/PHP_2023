<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Application\Dto\Output\Result;

interface RemoveDataInterface
{
    public function remove(int $id): Result;
}
