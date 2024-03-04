<?php
// Сложность O(n)
class Solution {

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator) {
        $number = $numerator/$denominator;
        $str = "".$number;
        $dec = explode ('.', $str);
        $str_dec = $dec[1];

        if ($str_dec==""){
            return $str;
        }

        if(strlen($str_dec)<2){
            return $str;
        }

        $dim=explode($str_dec[strlen($str_dec)-1],$str_dec);

        for ($i=(count($dim)-2);$i>=1;$i--){
            if($dim[$i]!=$dim[$i-1]){
                return $str;
            }
        }

        if($dim[0]==$dim[1]){
            return $dec[0].'.('.$dim[0].$str_dec[strlen($str_dec)-1].')';
        }else{
            return $dec[0].'.'.$dim[0].$str_dec[strlen($str_dec)-1].'('.$dim[1].$str_dec[strlen($str_dec)-1].')';
        }
    }
}
