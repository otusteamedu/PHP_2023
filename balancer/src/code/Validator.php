<?php
declare(strict_types=1);
namespace Ashishak\Balancer\code;

class Validator
{
    public static function ValidateText(string $postVar): array{
        $message = [];
        //Проверяем строку регуляркой, чтобы не прошла строка )(
        if (preg_match("/^\(.*\)/", $postVar)){
            if (preg_match_all("/(\()/u", $postVar, $m)){
                //количество открытых скобок
                $openCount = count($m[1]);

                //Удаляем по парам открытые и закрытые скобки
                for ($i=1; $i<=$openCount; $i++){
                    //Если в процессе выполнение понимаем что строка пуста, отдаем 200 код, все ок
                    if (empty($postVar)){
                        $message['code'] = 200;
                        $message['request'] = "Строка корректна!";
                        return $message;
                    } else {
                        $postVar = str_replace('()', '', $postVar);
                    }

                }
                //После прохождения цикла делаем контрольную проверку
                if(!empty($postVar)){
                    $message['code'] = '400';
                    $message['request'] = "В строке выявлены ОШИБКИ!!!";
                } else{
                    $message['code'] = 200;
                    $message['request'] = "Строка корректна!";
                }
            }
        } else {
            $message['code'] = '400';
            $message['request'] = "В строке выявлены ОШИБКИ!!!";
        }

        return $message;
    }

}