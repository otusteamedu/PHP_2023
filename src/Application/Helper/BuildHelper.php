<?php

namespace App\Application\Helper;

class BuildHelper
{
    public function getHashArrayFromString(string $string, string $delimiter1 = ';', string $delimiter2 = '='): array
    {
        $result = [];

        foreach (explode($delimiter1, $string) as $str) {
            $partsString = explode($delimiter2, $str);

            if (count($partsString) == 2) {
                $result[$partsString[0]] = $partsString[1];
            }
        }

        return $result;
    }
}
