<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Exception;
use Vp\App\Exceptions\AddEntityFailed;
use Vp\App\Exceptions\FindEntityFailed;
use Vp\App\Message;
use Vp\App\Result\ResultInit;

class Init
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DataBase::getInstance()->getConnection();
    }

    public function work(): ResultInit
    {
        $this->dropUsers();
        $this->dropProfiles();
        $this->createProfileTable();
        $this->createUserTable();

        try {
            $this->fillData();
        } catch (AddEntityFailed|FindEntityFailed $e) {
            return new ResultInit(false, $e->getMessage());
        }

        return new ResultInit(true, Message::SUCCESS_CREATE_DATA);
    }

    private function dropUsers(): void
    {
        $this->conn->exec('DROP TABLE users');
    }

    private function dropProfiles(): void
    {
        $this->conn->exec('DROP TABLE profiles');
    }

    private function createProfileTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS profiles (
                        id serial PRIMARY KEY,
                        first_name VARCHAR(50) NOT NULL,
                        last_name VARCHAR(50) NOT NULL
                        )";
        $this->conn->exec($sql);
    }

    private function createUserTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
                        id serial PRIMARY KEY,
                        login VARCHAR(50) NOT NULL,
                        email VARCHAR(50) NOT NULL,
                        profile_id INT NOT NULL,
                        CONSTRAINT c_fk_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE RESTRICT
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
        $profiles = $this->addProfiles($data);

        foreach ($profiles as $profile) {
            if (!isset($data[$profile['first_name']])) {
                continue;
            }
            $result = $this->addUser($profile, $data);
            if ($result === false) {
                throw new AddEntityFailed(Message::FAILED_CREATE_ENTITY);
            }
        }
    }

    private function getData(): array
    {
        return [
            'Ivan' => [
                'login' => 'ivan',
                'email' => 'ivan@test.ru',
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
            ],
            'Mihail' => [
                'login' => 'mihail',
                'email' => 'mihail@test.ru',
                'first_name' => 'Mihail',
                'last_name' => 'Petrov',
            ],
            'David' => [
                'login' => 'david',
                'email' => 'david@test.ru',
                'first_name' => 'David',
                'last_name' => 'Beroev',
            ],
            'Alexandr' => [
                'login' => 'alex',
                'email' => 'alex@test.ru',
                'first_name' => 'Alexandr',
                'last_name' => 'Sergeev',
            ],
            'Petr' => [
                'login' => 'petr',
                'email' => 'petr@test.ru',
                'first_name' => 'Petr',
                'last_name' => 'Vasin',
            ]
        ];
    }

    /**
     * @throws AddEntityFailed|FindEntityFailed
     */
    private function addProfiles(array $data): array
    {
        foreach ($data as $user) {
            $result = $this->addProfile($user['first_name'], $user['last_name']);
            if ($result === false) {
                throw new AddEntityFailed(Message::FAILED_CREATE_ENTITY);
            }
        }

        return $this->getProfiles();
    }

    private function addProfile(string $firstName, string $lastName): bool
    {
        $sql = 'INSERT INTO profiles (first_name, last_name) VALUES(:first_name, :last_name)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        return $stmt->execute();
    }

    /**
     * @throws FindEntityFailed
     */
    public function getProfiles(): array
    {
        $sql = "SELECT id, first_name, last_name FROM profiles";
        $list = [];

        try {
            foreach ($this->conn->query($sql) as $row) {
                $profile['id'] = $row['id'];
                $profile['first_name'] = $row['first_name'];
                $profile['last_name'] = $row['last_name'];
                $list[] = $profile;
            }
            return $list;
        } catch (Exception $e) {
            throw new FindEntityFailed(Message::FAILED_READ_ENTITY . ': ' . $e->getMessage());
        }
    }

    private function addUser(array $profile, array $data): bool
    {
        $user = $data[$profile['first_name']];
        $sql = 'INSERT INTO users (login, email, profile_id) VALUES(:login, :email, :profile_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':login', $user['login']);
        $stmt->bindValue(':email', $user['email']);
        $stmt->bindValue(':profile_id', $profile['id']);
        return $stmt->execute();
    }
}
