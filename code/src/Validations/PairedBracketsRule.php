<?php

declare(strict_types=1);

namespace Gkarman\Balanser\Validations;

class PairedBracketsRule
{
    public function isValid(string $brackets): bool
    {
        if (empty($brackets)) {
            return false;
        }

        while (!empty($brackets)) {
            $pos = strripos($brackets, '()');
            if ($pos === false) {
                return false;
            }
            $brackets = str_replace('()', '', $brackets);
        }

       return true;
    }

    public function message(): string
    {
        return 'Строка содержит неверное кол-во или порядок скобок';
    }
}
