<?php

class CheckRequest
{

    public function checkString(string $string) {
        return preg_match('/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/m', $string);
    }

}