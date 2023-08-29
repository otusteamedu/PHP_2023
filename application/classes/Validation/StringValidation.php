<?php

declare(strict_types=1);

namespace classes\Validation;

class StringValidation {

    public static function validation(string $str): bool
    {
        if (empty($str))
        {
            return false;
        }
    
        if (preg_match('/^[()]+$/', $str) !== 1)
        {
            return false;
        }
    
        $count = 0;
    
        for ($i = 0; $i < strlen($str); ++$i) 
        {
            
            $count = ($str[$i] === '(')? ++$count : --$count;
            
            if ($count < 0) 
            {
                return false;
            }
        }
    
        return $count === 0;
    }

}