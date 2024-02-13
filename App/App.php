<?php

declare(strict_types=1);

namespace App;

use src\Queue\Infrastructure\Controller\QueueController;

class App
{
    public function run()
    {
        match ($_ENV["REQUEST_URI"]) {
            '/' => $this->home(),
            '/check' => $this->check()
        };
    }

    private function home(): void
    {
        if ($_ENV["REQUEST_METHOD"] === 'GET') {
            echo file_get_contents(__DIR__ . '/home.html');
        } else {
            $controller = new QueueController();
            $controller->save($_POST);
        }
    }

    private function check(): void
    {
        if ($_ENV["REQUEST_METHOD"] === 'GET') {
            echo file_get_contents(__DIR__ . '/check.html');
        } else {
            $controller = new QueueController();
            $controller->check($_POST);
        }
    }
}
