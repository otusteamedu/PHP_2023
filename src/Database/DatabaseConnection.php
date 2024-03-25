<?php

namespace Rabbit\Daniel\Database;

use PDO;
use PDOException;

class DatabaseConnection
{
    /**
     * @var PDO Инстанс PDO для соединения с базой данных.
     */
    private $connection;

    /**
     * @var string DSN (Data Source Name) для подключения к базе данных.
     */
    private $dsn;

    /**
     * @var string Имя пользователя базы данных.
     */
    private $username;

    /**
     * @var string Пароль пользователя базы данных.
     */
    private $password;

    /**
     * Конструктор класса DatabaseConnection.
     *
     * @param string $dsn DSN для подключения к базе данных.
     * @param string $username Имя пользователя.
     * @param string $password Пароль.
     */
    public function __construct(string $dsn, string $username, string $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Устанавливает соединение с базой данных.
     *
     * @return void
     */
    public function connect(): void
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO($this->dsn, $this->username, $this->password);
                // Устанавливаем режим обработки ошибок PDO в исключения
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // В реальном приложении здесь может быть логирование или другая логика обработки ошибок
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
    }

    /**
     * Получает объект соединения с базой данных.
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        $this->connect(); // Убедитесь, что соединение установлено
        return $this->connection;
    }

    /**
     * Закрывает соединение с базой данных.
     *
     * @return void
     */
    public function close(): void
    {
        $this->connection = null;
    }
}