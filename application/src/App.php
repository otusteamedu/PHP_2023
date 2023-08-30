<?php

declare(strict_types=1);

namespace Gesparo\Hw;

use Dotenv\Dotenv;
use Gesparo\Hw\Controller\MainController;

class App
{
    public function run(): void
    {
        try {
            Dotenv::createImmutable(PathHelper::getInstance()->getRootPath())->load();

            (new MainController())->index();
        } catch (\Throwable $exception) {
            (new ExceptionHandler())->handle($exception);
        }
    }
}