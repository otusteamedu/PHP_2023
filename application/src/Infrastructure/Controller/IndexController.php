<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;

class IndexController implements ControllerInterface
{
    public function run(): Response
    {
        $info = <<<INFO
        <h1>Доступные методы:</h1>
        <ul>
            <li>GET / - выводит список доступных методов</li>
            <li>POST /add - добавляет элемент(ы) в список</li>
            <li>POST /clear - очищает все события</li>
            <li>POST /get - возвращает событие по заданному критерию</li>
        </ul>
        INFO;

        return new Response($info);
    }
}
