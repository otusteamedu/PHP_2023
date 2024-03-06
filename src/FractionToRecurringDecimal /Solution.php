<?php
declare(strict_types=1);

namespace App\FractionToRecurringDecimal;

class Solution
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        $expressionResult = $numerator / $denominator;
        $arrayResult      = explode('.', (string)$expressionResult);
        $integerResult    = $arrayResult[0];
        $remainderResult  = match (count($arrayResult)) {
            1 => '',
            2 => $arrayResult[1],
        };

        if (strlen($remainderResult) > 3) {
            $remainderOfDivision = $numerator % $denominator;
            $repeatingRemainder  = '';
            $divisorList         = [];

            while (strlen($repeatingRemainder) < 7) {
                if (isset($divisorList[$remainderOfDivision])) {
                    return sprintf('%s.(%s)', $integerResult, $repeatingRemainder);
                }

                $divisorList[$remainderOfDivision] = true;
                $remainderOfDivision               *= 10;
                $repeatingRemainder                .= (int)($remainderOfDivision / $denominator);

                $remainderOfDivision = $remainderOfDivision % $denominator;
            }
        }

        return (string)$expressionResult;
    }
}
