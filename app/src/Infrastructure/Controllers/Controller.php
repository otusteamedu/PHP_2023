<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure\Controllers;

class Controller
{
    /**
     * @param array|string $data
     * @param integer $code
     * @return void
     */
    public function response(mixed $data = '', $code = 200)
    {
        header('Content-type: application/json');
        http_response_code($code);
        echo json_encode($data);
    }
}
