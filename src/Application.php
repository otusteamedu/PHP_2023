<?php

declare(strict_types=1);

namespace Santonov\Otus;

final class Application
{
    public function process(): Response
    {
        $message = 'Запрос обработан ' . $_SERVER['HOSTNAME'];
        $baseString = $_POST['string'] ?? null;
        if (!is_string($baseString) || empty($baseString)) {
            return new Response(
                $message . ' Неверные входные данные',
                400,
            );
        }

        if (Validator::openedClosedBrackets($baseString)) {
            return new Response(
                $message . ' Всё хорошо!',
                200,
            );
        }

        return new Response(
            $message . 'Неправильно установлены скобки!',
            400,
        );
    }
}
