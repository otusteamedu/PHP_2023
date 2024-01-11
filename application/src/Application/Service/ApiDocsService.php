<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Service;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\PathHelper;
use Gesparo\Homework\Application\Response\ApiDocsResponse;
use OpenApi\Generator;

class ApiDocsService
{
    public function __construct(
        private readonly PathHelper $pathHelper
    )
    {
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function get(): ApiDocsResponse
    {
        $openapi = Generator::scan([
            $this->pathHelper->getControllersPath(),
            $this->pathHelper->getResponsesPath(),
            $this->pathHelper->getRequestsPath()
        ]);

        if ($openapi === null) {
            throw AppException::cannotScanProjectForGettingDocumentation($this->pathHelper->getControllersPath());
        }

        return new ApiDocsResponse(json_decode($openapi->toJson(), true, 512, JSON_THROW_ON_ERROR));
    }
}
