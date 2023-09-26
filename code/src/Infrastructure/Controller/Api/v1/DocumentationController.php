<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Controller\Api\v1;

class DocumentationController
{
    public function index(): void
    {
        header('Content-Type: application/json');
        $openapi = \OpenApi\Generator::scan([__DIR__]);
        echo $openapi->toJson();
    }
}