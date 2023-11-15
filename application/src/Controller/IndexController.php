<?php

declare(strict_types=1);

namespace Gesparo\HW\Controller;

use Symfony\Component\HttpFoundation\Response;

class IndexController implements ControllerInterface
{
    public function run(): Response
    {
        $info = <<<INFO
        <h1>Доступные методы:</h1>
        <ul>
            <li>GET / - выводит список доступных методов</li>
            <li>POST /send - отправляет смс. Принимает параметры: POST['phone'], POST['message']</li>
            <li>POST /queue - показывает очередь отправки</li>
        </ul>
        INFO;

        return new Response($info);
    }
}
