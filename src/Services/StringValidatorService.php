<?php

namespace Services;

class StringValidatorService
{
    public function isBracketsValid($string) {
        $stringToArr = str_split($string);
        $openingClosingMatchSymbols = ['(' => ')', '{' => '}', '[' => ']'];
        $closingSymbolOpeningMatch = array_flip($openingClosingMatchSymbols);
        $stack = [];

        foreach ($stringToArr as $key) {
            if(array_key_exists($key, $openingClosingMatchSymbols)) {
                $stack[] = $key;
            } else {
                if(count($stack) === 0) {
                    return false;
                }
                else if($closingSymbolOpeningMatch[$key] === end($stack)) {
                    array_pop($stack);
                }
            }
        }

        return empty($stack);
    }
}
