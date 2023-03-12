<?php

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

$address = dirname(__FILE__, 3)."/socket/server.sock";
unlink($address);

fwrite(STDOUT, "Создаем socket" . PHP_EOL);

if (($sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
    $error = "Ошибка. Не удалось создать сокет: " . socket_strerror(socket_last_error());
    fwrite(STDOUT, $error . PHP_EOL);
}

fwrite(STDOUT, "Привязываем адрес источника" . PHP_EOL);

if (socket_bind($sock, $address) === false) {
    $error = "Ошибка. Не удалось привязать адрес источника: " . socket_strerror(socket_last_error($sock));
    fwrite(STDOUT, $error . PHP_EOL);
}

fwrite(STDOUT, "Включаем прослушивание входящих сообщений" . PHP_EOL);

if (socket_listen($sock, 5) === false) {
    $error = "Ошибка. Не удалось включить прослушивание: " . socket_strerror(socket_last_error($sock));
    fwrite(STDOUT, $error . PHP_EOL);
}

while (true) {
    fwrite(STDOUT, "Включаем прием сообщений" . PHP_EOL);
    $msgSock = socket_accept($sock);

    if ($msgSock === false) {
        $error = "Ошибка. Не удалось включить прием сообщений: " . socket_strerror(socket_last_error($sock));
        fwrite(STDOUT, $error . PHP_EOL);
        break;
    }

    while (true) {
        $inbound = socket_read($msgSock, 255);

        if ($inbound === false) {
            $error = "Ошибка. Не удалось прочитать сообщений: " . socket_strerror(socket_last_error($msgSock));
            fwrite(STDOUT, $error . PHP_EOL);
            socket_close($msgSock);
            break 2;
        }

        if ($inbound == 'stop') {
            fwrite(STDOUT, PHP_EOL . "Клиент отключился" . PHP_EOL);
            socket_close($msgSock);
            break 2;
        }

        fwrite(STDOUT, "---------------" . PHP_EOL);
        fwrite(STDOUT, $inbound . PHP_EOL);

        $response = "Получено сообщение '$inbound'" . PHP_EOL;
        $write = socket_write($msgSock, $response, strlen($response));

        if (!$write) {
            fwrite(STDOUT, "Ошибка. Клиент закрыл соединение" . PHP_EOL);
            socket_close($msgSock);
            break 2;
        }
    }
}

fwrite(STDOUT, "Закрываем сокет." . PHP_EOL);
socket_close($sock);
