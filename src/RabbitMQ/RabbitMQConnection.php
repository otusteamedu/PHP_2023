<?php

namespace Rabbit\Daniel\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnection
{
    /**
     * @var AMQPStreamConnection Соединение с RabbitMQ.
     */
    private $connection;

    /**
     * @var string Хост RabbitMQ.
     */
    private $host;

    /**
     * @var int Порт RabbitMQ.
     */
    private $port;

    /**
     * @var string Имя пользователя для соединения с RabbitMQ.
     */
    private $user;

    /**
     * @var string Пароль для соединения с RabbitMQ.
     */
    private $password;

    /**
     * Конструктор класса RabbitMQConnection.
     *
     * @param string $host Хост RabbitMQ.
     * @param int $port Порт RabbitMQ.
     * @param string $user Имя пользователя.
     * @param string $password Пароль.
     */
    public function __construct(string $host, int $port, string $user, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Устанавливает соединение с RabbitMQ.
     *
     * @return void
     * @throws \Exception
     */
    public function connect(): void
    {
        if ($this->connection === null) {
            $this->connection = new AMQPStreamConnection(
                $this->host,
                $this->port,
                $this->user,
                $this->password
            );
        }
    }

    /**
     * Закрывает соединение с RabbitMQ, если оно открыто.
     *
     * @return void
     */
    public function close(): void
    {
        if ($this->connection !== null) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    /**
     * Возвращает канал для взаимодействия с RabbitMQ.
     *
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel()
    {
        $this->connect(); // Убедитесь, что соединение установлено
        return $this->connection->channel();
    }

    /**
     * Деструктор класса RabbitMQConnection.
     * Автоматически закрывает соединение при уничтожении объекта.
     */
    public function __destruct()
    {
        $this->close();
    }
}