<?php

namespace Rofflexor\Hw\Controllers;

use Illuminate\Http\Request;
use Laminas\Diactoros\Response\JsonResponse;
use MiladRahimi\PhpContainer\Container;
use Rofflexor\Hw\Actions\CheckEmailAction;

class CheckEmailController
{
    public function handle(): JsonResponse
    {
        if(isset($_POST['string'])) {
            $isValidateBrackets =  (new CheckEmailAction())->run($_POST['string']);
            if($isValidateBrackets) {
                return new JsonResponse(['message' => 'Строка валидна!']);
            }
            return new JsonResponse(['message' => 'Строка Невалидна!'], 400);
        }
        return new JsonResponse(['message' => 'Bad request'], 400);
    }

}