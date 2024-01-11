<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure;

use Symfony\Component\HttpFoundation\Request;

class AbstractController
{
    public function __construct(
        protected readonly Request $request
    ) {
    }
}
