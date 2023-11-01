<?php

declare(strict_types=1);

namespace Gesparo\HW;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class App
{
    /**
     * @param string $rootPath
     */
    public function run(string $rootPath): void
    {
        try {
            $pathHelper = $this->getPathHelper($rootPath);
            $request = $this->getRequest();
            $urlMatcher = $this->getUrlMatcher($request, $pathHelper);
            $envManager = $this->getEnvManager($pathHelper);

            $response = $this->navigate($urlMatcher, $request, $envManager);
        } catch (\Throwable $e) {
            $response = (new ExceptionHandler())->handle($e);
        }

        $response->send();
    }

    private function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    private function getPathHelper(string $rootPath): PathHelper
    {
        return PathHelper::initInstance($rootPath);
    }

    /**
     * @throws AppException
     */
    private function getUrlMatcher(Request $request, PathHelper $pathHelper): UrlMatcher
    {
        return (new UrlMatcherCreator($request, $pathHelper->getNavigationFilePath()))->create();
    }

    /**
     * @throws AppException
     */
    private function getEnvManager(PathHelper $pathHelper): EnvManager
    {
        return (new EnvCreator($pathHelper->getEnvFilePath()))->create();
    }

    /**
     * @throws AppException
     * @throws \RedisException
     */
    private function navigate(UrlMatcher $matcher, Request $request, EnvManager $envManager): Response
    {
        return (new ControllerNavigationStrategy($matcher, $request, $envManager))->run();
    }
}