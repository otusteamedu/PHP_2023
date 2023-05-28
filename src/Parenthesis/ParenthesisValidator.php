<?php

declare(strict_types=1);

namespace Otus\App\Parenthesis;

use Otus\App\Validator\ValidatorInterface;

final class ParenthesisValidator implements ValidatorInterface
{
    public function validate(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        $counter = 0;

        foreach (str_split($string) as $char) {
            if ($char === '(') {
                $counter++;
            } elseif ($char === ')') {
                $counter--;

                if ($counter < 0) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return $counter === 0;
    }
}
