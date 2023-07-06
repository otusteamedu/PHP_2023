<?php

namespace App;

class Validator
{
    public function checkString(): string
    {
        $inputString = $_POST['string'] ?? '';

        if ($inputString === '') {
            return $this->response(400, 'String is empty');
        }

        $bracketsCount = 0;

        for ($i = 0, $iMax = strlen($inputString); $i < $iMax; $i++) {
            if ($inputString[$i] === '(') {
                $bracketsCount++;
            } elseif ($inputString[$i] === ')') {
                $bracketsCount--;
            }
            if ($bracketsCount < 0) {
                return $this->response(400, 'Brackets are not balanced');
            }
        }

        if ($bracketsCount === 0) {
            return $this->response();
        }

        return $this->response(400, 'Brackets are not balanced');
    }

    public function response($code = 200, $message = 'OK'): string
    {
        http_response_code($code);
        return $message;
    }
}
