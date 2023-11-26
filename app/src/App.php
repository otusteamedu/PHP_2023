<?php

namespace Artyom\Php2023;

use Artyom\Php2023\components\BracketsValidator;
use Artyom\Php2023\helpers\ResponseHelper;
use Exception;

class App
{
    /**
     * @return string
     */
    public function run(): string
    {
        if ($_POST) {
            $bracketValidator = new BracketsValidator();

            try {
                $result = $bracketValidator->validate($_POST['string'] ?? '');

                return $result
                    ? ResponseHelper::successResponse('Строка со скобками валидна')
                    : ResponseHelper::errorResponse('Строка со скобками не валидна');
            } catch (Exception $e) {
                return ResponseHelper::errorResponse($e->getMessage());
            }
        } else {
            return file_get_contents('../src/views/bracketsValidator.html');
        }
    }
}
