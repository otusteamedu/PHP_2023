<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Infrastructure\Contract;

interface ResponseEmitterContract
{
    public function emit(): string;
    public function emitCode(int $code = 200): bool|int;
}
