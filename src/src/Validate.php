<?php

declare(strict_types=1);

namespace nikitaglobal;

class Validate
{
    public function __construct()
    {
        $string = $_POST['string'] ?? '';
        $this->checkString($string) ? http_response_code(200) : http_response_code(400);
    }
    public function checkString(string $inputString): bool
    {
        if ('' === $inputString) {
            echo 'Empty string';
            return false;
        }

        $bracketsCount = 0;

        for ($i = 0; $i < strlen($inputString); $i++) {
            if ($inputString[$i] == '(') {
                $bracketsCount++;
            } elseif ($inputString[$i] == ')') {
                $bracketsCount--;
            }
            if ($bracketsCount < 0) {
                return false;
            }
        }

        return 0 === $bracketsCount;
    }
}
