<?php
declare(strict_types=1);

namespace Validators;

class RequestValidator
{
    public static function validateRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['emails']) || !is_array($input['emails'])) {
            http_response_code(400);
            exit('Invalid input');
        }
    }
}