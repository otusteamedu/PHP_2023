<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vp\App\Infrastructure\Middleware\Contract\MiddleWareInterface;

class Auth implements MiddleWareInterface
{
    public function handle(Request $request, Application $app): ?Response
    {
        if ($this->checkToken($request, $app)) {
            return null;
        }

        return (new Response())
            ->setContent(json_encode([]))
            ->setStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    private function checkToken(Request $request, Application $app): bool
    {
        if (!$app['config']->getApiKeyName()) {
            return false;
        }

        if (!$app['config']->getApiToken()) {
            return false;
        }

        $token = $request->headers->get($app['config']->getApiKeyName());

        return $token == $app['config']->getApiToken();
    }
}
