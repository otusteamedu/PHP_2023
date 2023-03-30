<?php

declare(strict_types=1);

namespace Validators;

use Exception;

class RequestValidator
{
    /**
     * @throws Exception
     */
    public static function validateRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Method not allowed', 405);
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['emails']) || !is_array($input['emails'])) {
            throw new Exception('Invalid input', 400);
        }
    }
}
