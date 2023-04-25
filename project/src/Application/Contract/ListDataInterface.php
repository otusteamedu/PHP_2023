<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Infrastructure\Console\Result\ResultList;
use Vp\App\Infrastructure\Exception\MethodNotFound;

interface ListDataInterface
{
    /**
     * @throws MethodNotFound
     */
    public function list(string $context): ResultList;
}
