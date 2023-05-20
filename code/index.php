<?php

try
{
    if(!isset($_POST["string"]))
    {
        throw new \Exception("Не передана строка для проверки");
    }

    $sInputString = $_POST["string"];

    if(empty($sInputString))
    {
        throw new \Exception("Передана пустая строка");
    }

    if(isParenthesesCorrectlyPlaced($sInputString))
    {
        echo "Все ок";
    }
    else
    {
        throw new \Exception("Неверно расположены скобочки в строке");
    }
}
catch(\Exception $obThrownException)
{
    http_response_code(400);
    echo $obThrownException->getMessage();
}


function isParenthesesCorrectlyPlaced($sVerificateValue)
{
    $iOpenedParenthesesCount = 0;
    $iVerificateValueLength = mb_strlen($sVerificateValue);

    for($i = 0; $i < $iVerificateValueLength; $i++)
    {
        if(mb_substr($sVerificateValue, $i, 1) == "(")
        {
            $iOpenedParenthesesCount++;
        }
        else if(mb_substr($sVerificateValue, $i, 1) == ")")
        {
            $iOpenedParenthesesCount--;
        }

        if($iOpenedParenthesesCount < 0)
        {
            return false;
        }
    }

    return ($iOpenedParenthesesCount == 0);
}