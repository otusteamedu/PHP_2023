<?php

declare(strict_types=1);

namespace Twent\Hw13;

use PDO;
use Twent\Hw13\Database\Repository;
use Twent\Hw13\Traits\InteractsWithConfig;

final class App
{
    use InteractsWithConfig;

    private static string $configPath = __DIR__ . '/../config';

    private ?PDO $connect;

    public function __construct()
    {
        $this->connect = new PDO(
            config('database.pgsql.dsn'),
            options: [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public function __destruct()
    {
        $this->connect = null;
    }

    public function run(): void
    {
        $repository = new Repository($this->connect);

        $userMapper = $repository->load('user');

        $userMapper->insert([
            'firstname' => 'Name 6',
            'lastname' => 'Lastname 6',
            'email' => 'email6@mail.ru',
            'password' => 'password',
            'age' => 33
        ]);

        $id = intval($this->connect->lastInsertId());

        $user = $userMapper->find($id);
        echo "id: {$user->getId()}\n";
        echo "Возраст: {$user->getAge()}\n";

        $user->setAge(18);
        $userMapper->update($user);

        echo "Возраст после обновления: {$user->getAge()}\n";

        $userMapper->delete($user);
    }
}
