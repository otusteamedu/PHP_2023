<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\Application\PathHelper;
use Gesparo\Homework\Application\Service\ApiDocsService;

class ApiDocsServiceFactory
{
    public function __construct(
        private readonly PathHelper $pathHelper
    ) {
    }

    public function create(): ApiDocsService
    {
        return new ApiDocsService($this->pathHelper);
    }
}
