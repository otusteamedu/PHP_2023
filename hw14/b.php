<?php
/*
 * Сложность O(4^n)
 */
class Solution {

    function letterCombinations($digits) {
        $letters = [
            2=>['a','b','c'],
            3=>['d','e','f'],
            4=>['g','h','i'],
            5=>['j','k','l'],
            6=>['m','n','o'],
            7=>['p','q','r','s'],
            8=>['t','u','v'],
            9=>['w','x','y','z']
        ];

        if($digits<>""){
            $hash1 = $letters[$digits[0]];
        }else{
            $hash1=[];
        }

        for($i=1; $i<strlen($digits); $i++)
        {
            $hash2 = $letters[$digits[$i]];
            $hash12=Solution::array_union($hash1,$hash2);
            $hash1=$hash12;
        }
        return $hash1;
    }

    function array_union($array1,$array2)
    {
        foreach($array1 as $one1){
            foreach($array2 as $one2){
                $hash_union[]=$one1.$one2;
            }
        }
        return $hash_union;
    }

}