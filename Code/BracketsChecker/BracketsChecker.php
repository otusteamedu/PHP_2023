<?php

namespace Code\BracketsChecker;

class BracketsChecker
{
    public static function isBracketsBalanced(string $str): bool
    {
        $balance = 0;

        for ($i = 0, $len = strlen($str); $i < $len; $i++) {
            if ($str[$i] === '(') {
                $balance++;
            } elseif ($str[$i] === ')') {
                $balance--;
                if ($balance < 0) {
                    return false; // More closing brackets than opening ones
                }
            }
        }

        return $balance === 0;
    }
}