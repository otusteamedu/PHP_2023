<?php

namespace App;
class StringValidator
{
    function isValid($str) : bool
    {
        $braces = [
            '}' => '{',
            ')' => '(',
            ']' => '[',
        ];

        $stack = [];
        for($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];

            if (isset($braces[$char])) {
                $el = array_pop($stack);
                if ($el != $braces[$char]) {
                    return false;
                }
            } else {
                array_push($stack, $char);
            }
        }

        return !$stack;
    }
}