<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use Vp\App\Application\Dto\Output\ResultReport;
use Vp\App\Infrastructure\Exception\MethodNotFound;

interface ReportDataInterface
{
    /**
     * @throws MethodNotFound
     */
    public function report(string $context): ResultReport;
}
