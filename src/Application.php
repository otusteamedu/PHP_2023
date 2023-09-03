<?php

declare(strict_types=1);

namespace App;

use App\Validators\Parenthesis;
use DomainException;

final class Application
{
    public function run(): void
    {
        if (!empty($_POST)) {
            try {
                Parenthesis::validate($_POST['string'] ?? null);
                $this->response('Всё хорошо', 200);
            } catch (DomainException $e) {
                $this->response($e->getMessage(), 400);
            }
        }

        include __DIR__ . '/Views/form.html';
    }

    private function response(string $text, int $statusCode): void
    {
        http_response_code($statusCode);
        echo $text;
    }
}
