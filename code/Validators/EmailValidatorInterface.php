<?php

declare(strict_types=1);

namespace Validators;

interface EmailValidatorInterface
{
    public function validate(array $emails): array;
}
