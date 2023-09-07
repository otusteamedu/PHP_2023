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


$s = new Solution();
$numerator = 2;
$denominator = 1;
/*$numerator = 1;
$denominator = 2147483647;*/
$result = $s->fractionToDecimal($numerator, $denominator);
print_r($result);
die;//test_delete
for ($i = 1; $i < 100; $i++) {
    for ($j = 1; $j < 100; $j++) {
        $numerator = $i;
        $denominator = $j;
        $result = $s->fractionToDecimal($numerator, $denominator);
        echo print_r([$numerator,$denominator,$result],1).PHP_EOL.'<br>';
    }
}
//0,14285714285714285714285714285714