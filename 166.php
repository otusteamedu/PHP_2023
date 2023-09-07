<?php

class Solution
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return '0';
        }
        if ($denominator === 0) {
            return '';
        }
        
        $maxLen = pow(10, 4);
        $negative = ($numerator < 0 && $denominator >= 0) || ($numerator >= 0 && $denominator < 0) ? '-' : '';
        
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $positions = [];
        $intStr = $negative . strval(intdiv($numerator, $denominator));
        $maxLen = $maxLen - strlen(abs((int)$intStr)) - 1;
        $numerator = $numerator % $denominator;
        $floatStr = '';
        $repeatStr = '';
        
        $positions[$numerator] = 0;
        
        while (strlen($floatStr) < $maxLen && $numerator !== 0) {
            $numerator *= 10;
            $digit = intdiv($numerator, $denominator);
            $numerator = $numerator % $denominator;
            $floatStr .= $digit;
            if (!isset($positions[$numerator])) {
                $positions[$numerator] = strlen($floatStr);
            } else {
                $repeatStr = substr($floatStr, $positions[$numerator]);
                $floatStr = substr($floatStr, 0, $positions[$numerator]);
                break;
            }
        }
        
        $dec =  $floatStr;
        if($repeatStr){
            $dec.='(' . $repeatStr . ')';
        }
        if($dec){
            $intStr .= '.' . $dec ;
        }
        return $intStr;
    }
}
