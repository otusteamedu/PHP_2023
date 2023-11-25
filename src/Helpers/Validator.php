<?php

namespace Ekovalev\Otus\Helpers;

class Validator
{
    public static function openingClosingChar(string | null $stringChars, string $openChar, string $closingChar):string | bool
    {
        try {
            if (!is_string($stringChars) || strlen($stringChars) < 1) {
                throw new \Exception("Не передали строку с кол-ом символов");
            }
            $charCnt = 0;
            for($i = 0; $i < strlen($stringChars); $i++){
                if($stringChars[$i] === $openChar){
                    $charCnt++;
                }elseif ($stringChars[$i] === $closingChar){
                    $charCnt--;
                }
                if($charCnt < 0){
                    throw new \Exception("Нарушен порядок открывающих - закрывающих символов");
                }
            }
            if($charCnt !== 0){
                throw new \Exception("Нарушен порядок открывающих - закрывающих символов");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }
}