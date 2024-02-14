<?php

declare(strict_types=1);

namespace App;

use src\Queue\Infrastructure\Controller\QueueController;

class App
{
    public function run(): string
    {
        return match ($_ENV["REQUEST_URI"]) {
            '/' => $this->home(),
            '/check' => $this->check()
        };
    }

    private function home(): string
    {
        $controller = new QueueController();

        if ($_ENV["REQUEST_METHOD"] === 'GET') {
            return $controller->getFormSave();
        } else {
            return $controller->save();
        }
    }

    private function check(): string
    {
        $controller = new QueueController();

        if ($_ENV["REQUEST_METHOD"] === 'GET') {
            return $controller->getFromCheck();
        } else {
            return $controller->check();
        }
    }
}
