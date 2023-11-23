<?php

declare(strict_types=1);

namespace DShevchenko\Hw4;

require __DIR__ . '/validator.php';

use DShevchenko\Hw4\Validator;

class App
{
    public function run(): void
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                throw new \Exception("Method Not Allowed. Please use the POST method.");
            }

            // Получаем payload
            $rawPayload = file_get_contents('php://input');

            if (empty($rawPayload)) {
                throw new \Exception('Payload is empty.');
            }

            if (!Validator::validateString($rawPayload)) {
                throw new \Exception('Validation failed.');
            }

            echo 'Validation success.';
        } catch (\Exception $e) {
            // Устанавливаем код 400, если до этого не был установлен другой код
            if (http_response_code() === 200) {
                http_response_code(400);
            }
            echo $e->getMessage();
        }
    }
}
