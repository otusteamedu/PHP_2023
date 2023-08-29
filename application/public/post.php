<?php

declare(strict_types=1);

use classes\Exception\HttpException;
use classes\Validation\StringValidation;

require __DIR__ . "/../vendor/autoload.php";

try 
{
    
    if (!StringValidation::validation(trim($_POST['string'])))
    {
        throw new HttpException("'String' param is not valid", HttpException::CODE_400);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        throw new HttpException('Only post allowed', HttpException::CODE_400);
    }
    if (!array_key_exists('string', $_POST))
    {
        throw new HttpException("The 'string' parameter is missing", HttpException::CODE_400);
    }

    $string = trim($_POST['string']);

    echo "Your string '$string' is valid";

} 
catch (HttpException $exception) 
{
    //http_response_code(400);
    header("HTTP/1.1 {$exception->getCode()} {$exception->getMessage()}");
}
