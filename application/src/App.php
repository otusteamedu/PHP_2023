<?php

declare(strict_types=1);

namespace Gesparo\Homework;

interface App
{
    public function run(string $rootPath): void;
}
