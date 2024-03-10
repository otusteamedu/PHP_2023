<?php
declare(strict_types=1);

namespace Vasilaki\Ar\User\Gateways;

class UserGateway
{
    private static $identityMap = [];

    public function __construct(
        private int    $id,
        private string $username,
        private string $email,
        private int    $created_at
    )
    {

    }

    /**
     * @return \PDO
     */
    private static function getDB()
    {
        return new \PDO('mysql:host=localhost;dbname=my_database', 'username', 'password');
    }

    public static function getAllUsers()
    {
        $db = self::getDB();
        $query = $db->query('SELECT * FROM users');
        $users = [];

        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = new self($row['id'], $row['username'], $row['email'], $row['created_at']);
        }

        return $users;
    }


    public static function findById($id)
    {
        if (isset(self::$identityMap[$id])) {
            return self::$identityMap[$id];
        }

        $db = self::getDB();
        $query = $db->prepare('SELECT * FROM users WHERE id = :id');
        $query->execute(['id' => $id]);

        $row = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $user = new self($row['id'], $row['username'], $row['email'], $row['created_at']);
        self::$identityMap[$id] = $user;

        return $user;
    }
}