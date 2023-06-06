<?php

namespace Sva\Common\Domain;

class PhoneDigests
{
    const DIGESTS = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z']
    ];

    /**
     * @param string $digits
     * @return string[]
     */
    public static function letterCombinations(string $digits): array
    {
        if (strlen($digits) <= 0) {
            return [];
        }

        if (intval($digits) <= 0) {
            return [];
        }

        $result = [''];

        for ($i = 0; $i < strlen($digits); $i++) {
            $digit = $digits[$i];
            if ($digit < 2 || $digit > 9) {
                continue;
            }

            $r = [];
            foreach ($result as $item) {
                $letters = self::DIGESTS[$digit];

                foreach ($letters as $letter) {
                    $r[] = $item . $letter;
                }
            }

            $result = $r;
        }

        return $result;
    }
}
