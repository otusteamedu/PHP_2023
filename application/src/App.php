<?php

declare(strict_types=1);

namespace Gesparo\Hw;

use Dotenv\Dotenv;
use Gesparo\Hw\Controller\EmailService;

class App
{
    public function run(): void
    {
        try {
            Dotenv::createImmutable(PathHelper::getInstance()->getRootPath())->load();

            (new EmailService(
                $_ENV['DOMAIN_API'],
                PathHelper::getInstance()->getFilesPath() . 'emails.txt'
            ))->make();
        } catch (\Throwable $exception) {
            (new ExceptionHandler())->handle($exception);
        }
    }
}
