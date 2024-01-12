<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Response;

class ApiDocsResponse
{
    public function __construct(
        public array $content
    ) {
    }
}
