<?php

declare(strict_types=1);

namespace Otus\App\Validator;

interface ValidatorInterface
{
    public function validate(string $string): bool;
}
