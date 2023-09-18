<?php

namespace Rofflexor\Hw\Controllers;

use Illuminate\Http\Request;
use Laminas\Diactoros\Response\JsonResponse;
use MiladRahimi\PhpContainer\Container;
use Rofflexor\Hw\Actions\CheckEmailAction;

class CheckEmailController
{
    /**
     * @throws \Exception
     */
    public function handle(): JsonResponse
    {
        if(isset($_POST['email'])) {
            $validateEmails =  (new CheckEmailAction())->run($_POST['string']);
            if(count($validateEmails) > 0) {
                return new JsonResponse($validateEmails);
            }
            return new JsonResponse(['message' => 'Нет валидных Email'], 400);
        }
        return new JsonResponse(['message' => 'Bad request'], 400);
    }

}