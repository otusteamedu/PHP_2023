<?php

declare(strict_types = 1);

namespace ParenthesesStringVerificator;

class App {
    public function run()
    {
        try {
            if (!isset($_POST["string"])) {
                throw new \Exception("Не передана строка для проверки");
            }
        
            $sInputString = $_POST["string"];
        
            if (empty($sInputString)) {
                throw new \Exception("Передана пустая строка");
            }
        
            $obVerificator = new Verificator();
            if ($obVerificator->isParenthesesCorrectlyPlaced($sInputString)) {
                echo "Все ок";
            } else {
                throw new \Exception("Неверно расположены скобочки в строке");
            }
        } catch (\Exception $obThrownException) {
            http_response_code(400);
            echo $obThrownException->getMessage();
        }
    }
}
