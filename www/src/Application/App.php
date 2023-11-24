<?php

declare(strict_types=1);

namespace Dimal\Homework4\Application;

use Exception;
use Dimal\Homework4\Services\BracketsCheckerService;
use Dimal\Homework4\Services\HttpCodeService;

class App
{
    public function run()
    {
        try {
            if (!isset($_POST['string'])) {
                throw new Exception("Отсутсвует POST параметр string");
            }

            if (!($_POST['string'])) {
                throw new Exception("POST параметр string пустой");
            }

            $input_string = $_POST['string'];
            if (!BracketsCheckerService::checkBrackets($input_string)) {
                throw new Exception("Ошибка проверки скобок");
            }

            $htcode = new HttpCodeService(200);
            $htcode->sendHttpCode("Передан параметр \"$input_string\"");
        } catch (Exception $e) {
            $htcode = new HttpCodeService(400);
            $htcode->sendHttpCode($e->getMessage());
        }
    }
}
