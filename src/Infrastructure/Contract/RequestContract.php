<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Infrastructure\Contract;

interface RequestContract
{
    public function __get(string $key): ?string;
    public function isGet(): bool;
    public function isPost(): bool;
}
