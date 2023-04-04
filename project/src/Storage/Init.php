<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Exception;
use Vp\App\Exceptions\AddEntityFailed;
use Vp\App\Exceptions\FindEntityFailed;
use Vp\App\Message;
use Vp\App\Result\ResultInit;
use Vp\App\Services\DataBase;

class Init
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DataBase::getInstance()->getConnection();
    }

    public function work(): ResultInit
    {
        $this->dropProfiles();
        $this->dropUsers();
        $this->createUserTable();
        $this->createProfileTable();

        try {
            $this->fillData();
        } catch (AddEntityFailed|FindEntityFailed $e) {
            return new ResultInit(false, $e->getMessage());
        }

        return new ResultInit(true, Message::SUCCESS_CREATE_DATA);
    }

    private function dropUsers(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS users');
    }

    private function dropProfiles(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS profiles');
    }

    private function createProfileTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS profiles (
                        id serial PRIMARY KEY,
                        first_name VARCHAR(50) NOT NULL,
                        last_name VARCHAR(50) NOT NULL,
                        user_id INT NOT NULL,
                        CONSTRAINT c_fk_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
                        )";
        $this->conn->exec($sql);
    }

    private function createUserTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
                        id serial PRIMARY KEY,
                        login VARCHAR(50) NOT NULL,
                        email VARCHAR(50) NOT NULL
                        )";
        $this->conn->exec($sql);
    }

    /**
     * @throws AddEntityFailed
     * @throws FindEntityFailed
     */
    private function fillData(): void
    {
        $data = $this->getData();
        $users = $this->addUsers($data);

        foreach ($users as $user) {
            if (!isset($data[$user['login']])) {
                continue;
            }
            $result = $this->addProfile($user, $data);
            if ($result === false) {
                throw new AddEntityFailed(Message::FAILED_CREATE_ENTITY);
            }
        }
    }

    /**
     * @throws AddEntityFailed|FindEntityFailed
     */
    private function addUsers(array $data): array
    {
        foreach ($data as $user) {
            $result = $this->addUser($user['login'], $user['email']);
            if ($result === false) {
                throw new AddEntityFailed(Message::FAILED_CREATE_ENTITY);
            }
        }

        return $this->getUsers();
    }

    private function addUser(string $login, string $email): bool
    {
        $sql = 'INSERT INTO users (login, email) VALUES(:login, :email)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':email', $email);
        return $stmt->execute();
    }

    /**
     * @throws FindEntityFailed
     */
    public function getUsers(): array
    {
        $sql = "SELECT id, login, email FROM users";
        $list = [];

        try {
            foreach ($this->conn->query($sql) as $row) {
                $user['id'] = $row['id'];
                $user['login'] = $row['login'];
                $user['email'] = $row['email'];
                $list[] = $user;
            }
            return $list;
        } catch (Exception $e) {
            throw new FindEntityFailed(Message::FAILED_READ_ENTITY . ': ' . $e->getMessage());
        }
    }

    private function addProfile(array $user, array $data): bool
    {
        $profile = $data[$user['login']];
        $sql = 'INSERT INTO profiles (first_name, last_name, user_id) VALUES(:first_name, :last_name, :user_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':first_name', $profile['first_name']);
        $stmt->bindValue(':last_name', $profile['last_name']);
        $stmt->bindValue(':user_id', $user['id']);
        return $stmt->execute();
    }

    private function getData(): array
    {
        return [
            'ivan' => [
                'login' => 'ivan',
                'email' => 'ivan@test.ru',
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
            ],
            'mihail' => [
                'login' => 'mihail',
                'email' => 'mihail@test.ru',
                'first_name' => 'Mihail',
                'last_name' => 'Petrov',
            ],
            'david' => [
                'login' => 'david',
                'email' => 'david@test.ru',
                'first_name' => 'David',
                'last_name' => 'Beroev',
            ],
            'alex' => [
                'login' => 'alex',
                'email' => 'alex@test.ru',
                'first_name' => 'Alexandr',
                'last_name' => 'Sergeev',
            ],
            'petr' => [
                'login' => 'petr',
                'email' => 'petr@test.ru',
                'first_name' => 'Petr',
                'last_name' => 'Vasin',
            ]
        ];
    }
}
