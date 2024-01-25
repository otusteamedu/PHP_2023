<?php

namespace App\Helpers;

class Functions
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator) {
        return sprintf('%F', $numerator / $denominator);
    }
}
