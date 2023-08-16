<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\EmptyStringException;

class StringBracketsVerifier
{
    /**
     * @throws EmptyStringException
     */
    public function verify(string $s): bool
    {
        if ('' === $s) {
            throw new EmptyStringException();
        }

        $s = preg_replace('/[^(^)]/', '', $s);

        if ('' === $s) {
            return true;
        }

        $leftCount = 0;

        foreach (str_split($s) as $letter) {
            if ($letter === '(') {
                $leftCount++;
            } else {
                $leftCount--;
            }
            if ($leftCount < 0) {
                return false;
            }
        }
        return $leftCount === 0;
    }

    private function filterBrackets(string $s): string
    {
        return preg_replace('/[^(^)]/', '', $s);
    }
}