<?php
declare(strict_types=1);

namespace Elena\Hw5;

use Exception;

echo "Вы хотите проверить:".$_POST['email_str']."</br>";

try {
    if (!isset($_POST['email_str'])){
        throw new Exception('Отсутствует строка для проверки');
    }else{
        $email_str = $_POST['email_str'];
        $domain = preg_replace('/^([.a-z1-9])*/i',"",$email_str);
        $domain = preg_replace('/^(@){1}/i',"",$domain);
    }

    if (!filter_var($email_str, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Некорректный Email $email_str </br>");
    }

    if (!checkdnsrr($domain, 'MX')) {
        // домен недействителен
        throw new Exception("Некорректный домен $domain </br>");
    }

    echo ("Адрес $email_str корректный" );

} catch ( Exception $e){

    Echo "</br>";
    echo( "Ошибка проверки адреса $email_str - ". $e->getMessage() );
}
