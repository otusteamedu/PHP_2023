<?php

declare(strict_types=1);

namespace Santonov\Otus;

class Application
{
    public function process(): array
    {
        $result = [
            'hostname' => 'Запрос обработан ' . $_SERVER['HOSTNAME'],
        ];
        $baseString = $_POST['string'] ?? null;
        if (!is_string($baseString) || empty($baseString)) {
            http_response_code(400);
            $result['message'] = 'Неверные входные данные';
        } else {
            if (Validator::openedClosedBrackets($baseString)) {
                http_response_code(200);
                $result['message'] = 'Все хорошо!';
            } else {
                http_response_code(400);
                $result['message'] = 'Неправильно установлены скобки!';
            }
        }

        return $result;
    }
}
