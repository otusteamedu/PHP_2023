<?php

namespace App;

use Exception;

class App
{
    public function run()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method. Only POST is allowed.');
            }

            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);

            if (!isset($data['string'])) {
                throw new Exception('Invalid request: missing "string" parameter');
            }

            $string = $data['string'];

            if (empty($string)) {
                throw new Exception('Invalid string: empty input');
            }

            if ($this->checkValidString($string)) {
                http_response_code(200);
                echo 'Success: valid string';
            } else {
                throw new Exception('Invalid string');
            }


        } catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }


    private function checkValidString(string $input): bool
    {
        $stack = [];

        if ($input[0] === ")" || $input[mb_strlen($input) - 1] === "(") {
            return false;
        }

        for ($i = 0; $i < strlen($input); $i++) {
            $char = $input[$i];

            if ($char == '(') {
                array_push($stack, $char);
            } elseif ($char == ')') {
                if (empty($stack)) {
                    return false;
                }

                array_pop($stack);
            }
        }

        if (!empty($stack)) {
            return false;
        }

        return true;
    }
}