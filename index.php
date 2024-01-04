<?php
class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    public static function letterCombinations($digits) {
        $keyboard = [
            1 => null,
            2 => ["a","b","c"],
            3 => ["d","e","f"],
            4 => ["g","h","i"],
            5 => ["j","k","l"],
            6 => ["m","n","o"],
            7 => ["p","q","r","s"],
            8 => ["t","u","v"],
            9 => ["w","x","y","z"],
        ];

        if($digits == '') {
            return [];
        };

        $sol = $keyboard[$digits[0]];

        if(strlen($digits) > 1) {
            for ($i = 0; $i < strlen($digits)-1; $i++) {
                $tmp = [];
                for ($j = 0; $j < count($sol); $j++) {
                    if (isset($digits[$i+1])) {
                        for ($k = 0; $k < count($keyboard[$digits[$i+1]]); $k++) {
                            $tmp[] = $sol[$j].$keyboard[$digits[$i+1]][$k];
                        }
                    }
                }
                $sol = $tmp;
            }
        }
        return $sol;
    }
}

print_r(Solution::letterCombinations("234"));