<?php

declare(strict_types=1);

namespace App\Validator;

interface ValidatorInterface
{
    public function validateArrayIsKeyExists(array $data, array $keys): bool;
}
