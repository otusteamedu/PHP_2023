<?php

declare(strict_types=1);

namespace Vp\App\Application\Validator\Contract;

interface ValidatorInterface
{
    public function validate(string $result): bool;
}
