<?php

declare(strict_types=1);

namespace ParenthesesStringVerificator;

class Verificator
{
    public function isParenthesesCorrectlyPlaced($sVerificateValue)
    {
        $iOpenedParenthesesCount = 0;
        $iVerificateValueLength = mb_strlen($sVerificateValue);

        for ($i = 0; $i < $iVerificateValueLength; $i++) {
            if (mb_substr($sVerificateValue, $i, 1) == "(") {
                $iOpenedParenthesesCount++;
            } else if (mb_substr($sVerificateValue, $i, 1) == ")") {
                $iOpenedParenthesesCount--;
            }

            if ($iOpenedParenthesesCount < 0) {
                return false;
            }
        }

        return ($iOpenedParenthesesCount == 0);
    }
}
