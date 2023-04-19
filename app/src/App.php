<?php

namespace Yakovgulyuta\Hw5;

class App
{
    public function run(): void
    {
        try {
            $controller = new Controller();
            $controller->validateEmails();
        } catch (\Exception $e) {
            $this->sendResponse(400, $e->getMessage());
        }
    }

    private function sendResponse(int $code, string $message): void
    {
        http_response_code($code);
        echo $message;
    }
}
