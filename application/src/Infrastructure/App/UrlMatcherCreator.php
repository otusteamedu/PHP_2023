<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class UrlMatcherCreator
{
    private Request $request;
    private string $pathToNavigationFile;

    public function __construct(Request $request, string $pathToNavigationFile)
    {
        $this->request = $request;
        $this->pathToNavigationFile = $pathToNavigationFile;
    }

    /**
     * @throws AppException
     */
    public function create(): UrlMatcher
    {
        $this->checkRoutesExists();

        $context = new RequestContext();
        $context->fromRequest($this->request);

        return new UrlMatcher($this->getRoutes(), $context);
    }

    /**
     * @throws AppException
     */
    private function checkRoutesExists(): void
    {
        if (!file_exists($this->pathToNavigationFile)) {
            throw AppException::navigationFileNotExists($this->pathToNavigationFile);
        }

        if (!is_readable($this->pathToNavigationFile)) {
            throw AppException::navigationFileNotReadable($this->pathToNavigationFile);
        }
    }

    private function getRoutes(): RouteCollection
    {
        return require $this->pathToNavigationFile;
    }
}
