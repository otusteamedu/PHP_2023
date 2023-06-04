<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Middleware\Contract;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface MiddleWareInterface
{
    public function handle(Request $request, Application $app): ?Response;
}
