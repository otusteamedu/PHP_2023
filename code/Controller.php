<?php
declare(strict_types=1);

use Validator\Validator;

class Controller
{
    public function stringBalance(): void
    {
        try {
            (new Validator($_POST['string']))->validate();
            $this->sendResponse(200, 'The string has correctly balanced parentheses.');
        } catch (Exception $e) {
            $this->sendResponse(400, $e->getMessage());
        }
    }

    private function sendResponse(int $code, string $message): void
    {
        http_response_code($code);
        echo 'Error: ' . $message;
    }
}
