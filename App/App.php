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
        $controller = new QueueController();

        if ($_ENV["REQUEST_METHOD"] === 'GET') {
            $controller->getFormSave();
        } else {
            $controller->save();
        }
    }

    private function check(): void
    {
        $controller = new QueueController();

        if ($_ENV["REQUEST_METHOD"] === 'GET') {
            $controller->getFromCheck();
        } else {
            $controller->check();
        }
    }
}
