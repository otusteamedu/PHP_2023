<?php

declare(strict_types=1);

namespace nikitaglobal;

class Validate
{
    public function __construct()
    {
    }

    public function checkString(): void
    {
        $inputString = $_POST['string'] ?? '';
        if ('' === $inputString) {
            $this->generateResponse(400);
            return;
        }

        $bracketsCount = 0;

        for ($i = 0; $i < strlen($inputString); $i++) {
            if ($inputString[$i] == '(') {
                $bracketsCount++;
            } elseif ($inputString[$i] == ')') {
                $bracketsCount--;
            }
            if ($bracketsCount < 0) {
                $this->generateResponse(400);
            }
        }
        0 === $bracketsCount ? $this->generateResponse(200) : $this->generateResponse(400);
        return;
    }

    public function generateResponse($code = 200): void
    {
        http_response_code($code);
        return;
    }
}
