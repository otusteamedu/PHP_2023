<?php

declare(strict_types=1);

namespace App\Validator;

class Validator implements ValidatorInterface
{
    public function validateArrayIsKeyExists(array $data, array $keys): bool
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                return false;
            }
        }

        return true;
    }
}
