<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Domain\Contract;

use Twent\BracketsValidator\Domain\ValueObject\InputString;

interface ValidatorContract
{
    public function run(InputString $string): bool;
}
