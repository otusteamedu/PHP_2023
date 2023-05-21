<?php

declare(strict_types=1);

namespace Girevik1\WebSerBalancer\Helpers;

use Exception;

class RequestValidationHelper
{
    public static function checkBrackets(array $postRequestBody): bool
    {
        if ($postRequestBody === []) {
            throw new Exception('Запрос пустой!');
        }
        foreach ($postRequestBody as $key => $param) {
            $c = 0;
            for ($i = 0; $i < strlen($param); $i++) {
                if ($param[$i] === '(') {
                    $c++;
                } else if ($param[$i] === ')') {
                    $c--;
                }
                if ($c < 0) {
                    throw new Exception('Скобоки не корректны!');
                }
            }

            return $c === 0;
        }
    }
}
