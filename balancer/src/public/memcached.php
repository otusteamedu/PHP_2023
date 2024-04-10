<?php

session_start();

echo "Контейнер nginx: {$_SERVER['HOSTNAME']} <br><br>";

echo 'ID Сессии: ' . session_id() . '<br><br>';

echo '<hr><br><br>Проверка Сессии в Memcached:<br><br>';

if ($_SESSION['var']) {
    echo "Данные из сессии: " . $_SESSION['var'];
} else {
    $_SESSION['var'] = 'Эти данные записали, а теперь достали из сессии';
    echo 'Данные записаны в сессию успешно. Перезагрузите страницу.';
}
