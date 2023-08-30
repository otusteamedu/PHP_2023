<?php

namespace core\Api;

use classes\Exception\HttpException;
use classes\Validation\StringValidation;

class Post
{
    public static function PostListener():void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
            throw new HttpException('Only post allowed', HttpException::CODE_400);
        }

        $method = trim(array_keys($_POST)[0]);

        if (method_exists(__CLASS__,$method))
        {
            self::$method();
        }
        else
        {
            throw new HttpException("The '$method' parameter is missing", HttpException::CODE_400);
        }
    }


    public static function string()
    {
        $string = trim($_POST['string']);

        if (!StringValidation::validation($string)) 
        {
            throw new HttpException("'String' param is not valid", HttpException::CODE_400);
        }

        echo "Your string '$string' is valid";
    }
}
