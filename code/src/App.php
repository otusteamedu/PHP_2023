<?php

declare(strict_types=1);

namespace Gkarman\Balanser;

use Gkarman\Balanser\Validations\PairedBracketsRule;

class App
{
    public function run(): string
    {
        $string = $_POST['string'] ?? '';

        $rule = new PairedBracketsRule();
        $isValidStringWithBrackets = $rule->isValid($string);

        if ($isValidStringWithBrackets) {
            return $this->successResolver();
        }

        return $this->errorResolver($rule->message());
    }

    private function successResolver(): string
    {
        header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
        return "Все ок";
    }

    private function errorResolver(string $errorMessage): string
    {
        header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request");
        return $errorMessage;
    }
}
