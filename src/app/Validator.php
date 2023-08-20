<?php

namespace App;

class Validator
{
    /**
     * @param string $expression
     * @return bool
     */
    public static function checkIfBalanced(string $expression): bool
    {
        $stack = [];
        $startSymbols = ['('];
        $pairs = ['()'];

        for ($i = 0, $len = strlen($expression); $i < $len; $i++) {
            $curr = $expression[$i];
            if (in_array($curr, $startSymbols)) {
                array_push($stack, $curr);
            } else {
                $prev = array_pop($stack);
                $pair = "{$prev}{$curr}";
                if (!in_array($pair, $pairs)) {
                    return false;
                }
            }
        }

        return count($stack) === 0;
    }
}
