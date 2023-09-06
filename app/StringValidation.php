<?php

declare(strict_types=1);

namespace App;

use Exception;

class StringValidation
{
    public function validation(): void
    {
        $entityBody = file_get_contents('php://input');

        $body = json_decode($entityBody, true);

        if (!isset($body['string'])) {
            $this->showError(400, 'String not found');
        }

        $string = $body['string'];

        $arrayOfBrackets = str_split($string);

        $numberOfOpeningBrackets = 0;

        for ($i = 0; $i <= count($arrayOfBrackets) - 1; $i++) {
            $item = $arrayOfBrackets[$i];

            if ($item == '(') {
                $numberOfOpeningBrackets++;
            } elseif ($item == ')') {
                $numberOfOpeningBrackets--;
            }

            if ($numberOfOpeningBrackets < 0) {
                $this->showError(400, "String is not correct. Character number $i");
            }
        }

        if ($numberOfOpeningBrackets != 0) {
            $this->showError(400, "String is not correct. Character number $i");
        }

        echo 'String is valid';
    }

    private function showError(int $code, string $message)
    {
        http_response_code($code);
        throw new Exception($message, $code);
    }
}