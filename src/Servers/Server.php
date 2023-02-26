<?php

declare(strict_types=1);

namespace Twent\Chat\Servers;

use Twent\Chat\Servers\Contracts\ServerContract;
use Twent\Chat\Sockets\BaseSocketClient;
use Twent\Chat\Sockets\BaseSocketManager;
use Twent\Chat\Sockets\UnixSocketManager;

final class Server extends BaseServer
{
    public function __construct(
        BaseSocketClient|BaseSocketManager $socketManager,
        private array $connects = [],
    ) {
        parent::__construct($socketManager);
        // регистрация обработчика выхода из скрипта
        pcntl_async_signals(true);
        pcntl_signal(SIGINT, fn () => $this->shutdown());
    }

    public static function getInstance(): ?ServerContract
    {
        if (! self::$instance) {
            self::$instance = new self(UnixSocketManager::getInstance());
        }

        return self::$instance;
    }

    public function run(): void
    {
        while (true) {
            $connects = $this->connects;
            $connects[] = $this->socket;

            if (! $this->socketManager->select($connects)) {
                break;
            }

            // есть новое соединение
            if (in_array($this->socket, $connects)) {
                // принимаем
                $connect = $this->socketManager->accept();

                if ($connect) {
                    // добавляем в список для обработки
                    $this->connects[] = $connect;
                    $key = array_search($connect, $this->connects) + 1;
                    echo "Клиент {$key} подключен\n";
                }

                unset($connects[array_search($this->socket, $connects)]);
            }

            // обрабатываем все соединения
            foreach ($connects as $key => $connect) {
                $key++;
                $message = $this->socketManager->read($connect);

                if (! $message) {
                    // соединение было закрыто
                    echo "Клиент {$key} отключен.\n";
                    $this->socketManager->close($connect);
                    unset($this->connects[array_search($connect, $this->connects)]);
                    echo 'Подключено клиентов: ' . count($this->connects) . PHP_EOL;
                    break;
                }

                $bytes = strlen($message);
                echo "Сообщение от клиента {$key}: {$message}";
                echo $answer = "Размер сообщения: {$bytes} байт\n";
                $this->socketManager->write($answer, $connect);
            }

            unset($connects);
        }
    }

    protected function shutdown(): void
    {
        socket_shutdown($this->socket);
        socket_close($this->socket);
        echo "\nСервер остановлен.\n";
        exit;
    }
}
