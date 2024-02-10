<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class Controller
{
    /**
     * @param array|string $data
     * @param integer $code
     * @return void
     */
    public function response(mixed $data = '', $code = 200)
    {
        $response = new JsonResponse($data, $code);

        return $response->send();
    }
}
