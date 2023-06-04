<?php

namespace Sva\Common\Domain;

class PhoneDigests
{
    const DIGESTS = [
        2 => 'abc',
        3 => 'def',
        4 => 'ghi',
        5 => 'jkl',
        6 => 'mno',
        7 => 'pqrs',
        8 => 'tuv',
        9 => 'wxyz'
    ];

    /**
     * @param string $digits
     * @return string[]
     */
    public static function letterCombinations(string $digits): array
    {
        if(strlen($digits) <= 0) {
            return [];
        }

        $digits = str_split($digits);
        $result = [''];

        foreach ($digits as $key => $digit) {

            if($digit < 2 || $digit > 9) {
                continue;
            }

            $r = [];
            foreach ($result as $k => $item) {
                $letters = str_split(self::DIGESTS[$digit]);

                foreach ($letters as $letter) {
                    $r[] = $result[$k] . $letter;
                }
            }

            $result = $r;
        }

        return $result;
    }
}
