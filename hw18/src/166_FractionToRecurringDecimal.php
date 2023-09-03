<?php

namespace src;

class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        $result = $numerator / $denominator;
        $separatedResult = $this->separateFractionalPart((string)$result);
        $fractionalRepetition = $this->findFractionalRepetitions($separatedResult[1]);

        return $separatedResult[0] . ($fractionalRepetition ? '.' . $fractionalRepetition : '');
    }

    private function separateFractionalPart(string $decimal): array
    {
        $integerPart = '';
        $decimalPart = '';
        $foundPeriod = false;

        for ($i = 0; $i < strlen($decimal); $i++) {
            if ($decimal[$i] === '.') {
                $foundPeriod = true;
            } else {
                if ($foundPeriod) {
                    $decimalPart .= $decimal[$i];
                } else {
                    $integerPart .= $decimal[$i];
                }
            }
        }

        return [$integerPart, $decimalPart];
    }

    private function findFractionalRepetitions(string $fraction): string
    {
        $result = $fraction;

        if (strlen($fraction) > 1) {
            $search = '';
            for ($i = 0; $i < strlen($fraction); $i++) {
                $search .= $fraction[$i];

                $count = 0;
                for ($j = 0; $j < strlen($fraction); $j++) {
                    $fractionSearch = '';
                    for ($k = 0; $k < strlen($search); $k++) {
                        $fractionSearch .= $fraction[$j + $k];
                    }

                    if ($search === $fractionSearch) {
                        $count++;
                    }
                }

                if (($count * strlen($search)) === strlen($fraction)) {
                    $result = '(' . $search . ')';
                    break;
                }
            }
        }

        return $result;
    }
}
