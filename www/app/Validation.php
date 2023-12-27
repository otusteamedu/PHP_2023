<?php

declare(strict_types=1);

namespace Chernomordov\App;

use Exception;

class Validation
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        if ($this->isStringProvided()) {
            $this->validateParentheses();
        }

        include_once __DIR__ . '/Views/Form.php';
    }

    /**
     * @return bool
     */
    private function isStringProvided(): bool
    {
        return array_key_exists('string', $_REQUEST) && !is_null($_REQUEST['string']);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validateParentheses(): void
    {
        $string = $_REQUEST['string'];
        $numberOpen = 0;

        foreach (str_split($string) as $item) {
            if ($item === '(') {
                $numberOpen++;
            } elseif ($item === ')') {
                $numberOpen--;
            }

            if ($numberOpen < 0) {
                $this->handleValidationError();
            }
        }

        if ($numberOpen !== 0) {
            $this->handleValidationError();
        }

        echo 'Ок';
    }

    /**
     * @return void
     * @throws Exception
     */
    private function handleValidationError(): void
    {
        http_response_code(400);
        throw new Exception("Ошибка", 400);
    }
}
