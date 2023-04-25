<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Infrastructure\Console\Result\Result;
use Vp\App\Infrastructure\Exception\MethodNotFound;

interface ImportDataInterface
{
    /**
     * @throws MethodNotFound
     */
    public function import(string $fileName, string $context): Result;
}
