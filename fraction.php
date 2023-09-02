<?php

declare(strict_types=1);

final class Solution
{

    /**
     * Первый вариант, который работает только с несмешанными дробями
     */
    function wrongFractionToDecimal(int $numerator, int $denominator): string
    {
        $quotient = (string) ($numerator / $denominator);
        if (!str_contains($quotient, '.')) {
            return $quotient;
        }

        [$integerPart, $fractionalPart] = explode('.', $quotient);

        $hash = [$fractionalPart[0]];
        $isRepeat = false;
        $length = strlen($fractionalPart);
        for ($i = 1, $j = 0; $i < $length; $i++) {
            $num = $fractionalPart[$i];

            if (!array_key_exists($j, $hash)) {
                break;
            }

            if ($num === $hash[$j]) {
                $isRepeat = true;
                $j++;
            } else {
                $hash[] = $num;
                $isRepeat = false;
            }
        }

        return $integerPart . '.' . ($isRepeat ? sprintf('(%s)', implode($hash)) : $fractionalPart);
    }

    /**
     * Вариант, который проходит все тесты на литкоде.
     * Сложность данного алгоритма - линейная.
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return "0";
        }

        $sign = $numerator < 0 ^ $denominator < 0 ? '-' : '';
        $numerator = abs($numerator);
        $denominator = abs($denominator);
        $integer = (int) ($numerator / $denominator);
        $remainder = $numerator % $denominator;

        $result = $sign . $integer;

        if ($remainder === 0) {
            return $result;
        }

        $result .= ".";
        $fraction = "";

        $i = 0;
        $hash = [];
        while ($remainder !== 0) {
            if (array_key_exists($remainder, $hash)) {
                $main = substr($fraction, 0, $hash[$remainder]);
                $repeat = substr($fraction, $hash[$remainder], strlen($fraction));

                $fraction = $main . "($repeat)";
                break;
            }

            $hash[$remainder] = $i;
            $i++;

            $remainder *= 10;
            $fraction .= (int) ($remainder / $denominator);
            $remainder = $remainder % $denominator;
        }

        return $result . $fraction;
    }
}

echo (new Solution())->fractionToDecimal(-50, 8) . PHP_EOL;