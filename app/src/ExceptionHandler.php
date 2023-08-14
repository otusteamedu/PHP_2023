<?php
declare(strict_types=1);

namespace Root\App;

use Throwable;

class ExceptionHandler
{
    public function __invoke(Throwable $exception): void
    {
        Response::echo(false, ($exception instanceof AppException ? 'App error: ' : 'Fatal error: ') . $exception->getMessage());
    }

}