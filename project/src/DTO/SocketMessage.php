<?php

declare(strict_types=1);

namespace Vp\App\DTO;

class SocketMessage
{
    public const FAILED_CREATE_SOCKET = 'Ошибка. Не удалось создать сокет: %s';
    public const FAILED_BIND_SOCKET = 'Ошибка. Не удалось привязать адрес источника: %s';
    public const FAILED_LISTEN_SOCKET = 'Ошибка. Не удалось привязать адрес источника: %s';
    public const FAILED_RECEIVING_SOCKET = 'Ошибка. Не удалось включить прием сообщений: %s';
    public const FAILED_READ_MESSAGE = 'Ошибка. Не удалось прочитать сообщение:  %s';
    public const FAILED_SOCKET_CONNECT = 'Ошибка. Не удалось установить соединение. Убедитесь что сервер запущен (%s)';
    public const CLIENT_DISCONNECT = 'Клиент отключился';
    public const MESSAGE_SEPARATOR = '-----------------';
    public const RESPONSE_MESSAGE = "Получено сообщение: '%s'";
    public const SERVER_MESSAGE = PHP_EOL . "Ответ сервера: " . PHP_EOL . "%s";
    public const ERROR_CLIENT_CLOSED = 'Ошибка. Клиент закрыл соединение.';
    public const ERROR_SERVER_CLOSED = 'Ошибка. Сервер закрыл соединение.';
    public const CLOSE_SOCKET = 'Закрываем сокет.';
    public const SOCKET_CREATE = 'Сокет создан.';
    public const RECEIVING_SOCKET = 'Клиент подключился, прием сообщений включен.';
    public const SERVER_APP = "Сервер приложения 'Чат на сокетах'";
    public const CLIENT_APP = "Клиент приложения 'Чат на сокетах'";
    public const CLIENT_WELCOME = "Соединение установлено, можно отправлять сообщения! Чтобы отключиться введите stop.";
}
