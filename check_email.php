<?php

//получаем данные, проверяем не пустая ли строка и отображаем
if (empty($argv[1])) {
        echo "введите пожалуйста email" .PHP_EOL;
        exit(0);
} else {
        $var_add=$argv[1];
        echo "Вы ввели " . $var_add .PHP_EOL;
}


//считаем количество символов @
if ((substr_count($var_add, '@')) != '1') {
        echo "Пожалуйста введите корректный email" .PHP_EOL;
        exit(0);
} else {
        $var_check01=(substr_count($var_add, '@'));
        echo "Количество символов @ - " . $var_check01 .PHP_EOL;
}


//разбиваем email на две части по разделителю @
$var_email=(explode( '@', $var_add));
$var_postname=($var_email[0]);
$var_domain=($var_email[1]);
echo "Имя адресата " . $var_postname .PHP_EOL;
echo "Доменное имя " . $var_domain .PHP_EOL;


//проверка dns
if (empty(dns_get_record($var_domain))) {
        echo "Данных по " . $var_domain . " нет" .PHP_EOL;
        exit(0);
} else {
        $result = dns_get_record($var_domain);
        print_r($result);
}

?>
