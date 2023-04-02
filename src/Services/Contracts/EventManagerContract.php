<?php

declare(strict_types=1);

namespace Twent\Hw12\Services\Contracts;

use Symfony\Component\HttpFoundation\Request;

interface EventManagerContract
{
    public function create(Request $request);
    public function findById(int $id): ?array;
    public function findByConditions(Request $request): ?array;
}
