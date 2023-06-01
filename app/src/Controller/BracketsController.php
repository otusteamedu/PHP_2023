<?php

declare(strict_types=1);

namespace Lebedev\App\Controller;

use Exception;

class BracketsController extends AppController
{
    /**
     * "/brackets/is-valid" Endpoint - Get list of users
     *
     * @return void
     *
     * @throws Exception
     */
    public function validAction(): void
    {
        try {
            $queryParams = $this->getQueryParams();
            if (!count($queryParams) || !isset($queryParams['string'])) {
                throw new Exception('Отсутствует параметр string!');
            }
            $string = $queryParams['string'];
            if (!preg_match('/^[()]+$/', $string)) {
                throw new Exception('Строка должна содержать только символы скобок!');
            }

            $diff = 0;
            for ($i = 0; $i < strlen($string); $i++) {
                $diff = $string[$i] === '(' ? ++$diff : --$diff;
                if ($diff < 0) {
                    throw new Exception("Закрывающая скобка в позиции $i не сочетается ни с одной открывающейся!");
                }
            }

            if ($diff !== 0) {
                throw new Exception("Открывающих скобок больше, чем закрывающих!");
            }

            $this->response(
                json_encode(['success' => 'Строка из скобок валидна']),
                ['Content-Type: application/json', 'HTTP/1.1 200 OK']
            );
        } catch (Exception $exception) {
            $this->response(
                json_encode(['error' => $exception->getMessage()]),
                ['Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity']
            );
        }
    }
}
