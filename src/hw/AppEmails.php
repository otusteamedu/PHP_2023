<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\hw;

use Ndybnov\Hw06\commands\CheckEmailsCommand;
use Ndybnov\Hw06\commands\MockExternalDnsMxCheckCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

class AppEmails
{
    public function run(): void
    {
        try {
            $app = AppFactory::create();

            $app->get(
                '/',
                function (Request $request, Response $response): Response {
                    return (new CheckEmailsCommand())->run($request, $response);
                }
            );

            $app->post(
                '/',
                function (Request $request, Response $response): Response {
                    return (new MockExternalDnsMxCheckCommand())->run($request, $response);
                }
            );

            $app->run();
        } catch (\Exception $exception) {
            throw new $exception($exception->getMessage());
        }
    }
}
