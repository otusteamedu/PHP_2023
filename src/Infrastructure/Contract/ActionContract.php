<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Infrastructure\Contract;

use Twent\BracketsValidator\Infrastructure\Http\Request;

interface ActionContract
{
    public function handle(Request $request): void;
}
