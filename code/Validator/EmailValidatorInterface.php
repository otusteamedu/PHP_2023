<?php
declare(strict_types=1);

namespace code\Validator;
interface EmailValidatorInterface
{
    public function validate(array $emails): array;
}
