<?php

declare(strict_types=1);

namespace nikitaglobal;

class Validate
{
    public function __construct(string $string)
    {
        $this->checkString($string) ? http_response_code(200) : http_response_code(400);
    }
    public function checkString(string $inputString): bool
    {

    // Проверяем на корректность количества открытых и закрытых скобок
        $openCount = 0;
        $closeCount = 0;

        for ($i = 0; $i < strlen($inputString); $i++) {
            if ($inputString[$i] == '(') {
                $openCount++;
            } elseif ($inputString[$i] == ')') {
                $closeCount++;
            }
        }

        return $openCount === $closeCount;
    }
}
