<?php

declare(strict_types=1);

namespace App;

use App\Validators\BracketValidator;
use Exception;

class AppValidator
{
    public function runApp(): void
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Use POST method', 400);
            }

            $string = $_POST['string'] ?? '';

            if (empty($string)) {
                throw new Exception('Send me not empty "string" param', 400);
            }

            if (BracketValidator::validateString($string)) {
                echo "<h1>This is " . $_SERVER['HOSTNAME'] . "</h1>";
                echo sprintf('Валидация скобок в строке "<b>%s</b>" прошла успешно', $string);
                phpinfo();
            } else {
                echo sprintf('Строка "<b>%s</b>" не прошла валидацию на скобки', $string);
            }
        } catch (Exception $exception) {
            header("HTTP/1.1 {$exception->getCode()} {$exception->getMessage()}");
        }
    }
}
