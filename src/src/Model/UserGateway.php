<?php

namespace App\Model;

use App\Model\User as User;
use App\Model\UserIdentityMap as UserIdentityMap;

class UserGateway
{
    private $mysqli;

    public function __construct(\mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function findAll()
    {
        // Получаем всех пользователей из Identity Map
        $users = UserIdentityMap::getAllUsers();

        // Если пользователи уже загружены, возвращаем их
        if ($users !== []) {
            return $users;
        }

        // Если пользователи не найдены в Identity Map, выполняем запрос к базе данных
        $query = "SELECT * FROM users";
        $result = $this->mysqli->query($query);
        $users = [];
        while ($userData = $result->fetch_assoc()) {
            $user = new User();
            $user->id = $userData['id'];
            $user->name = $userData['name'];
            $user->email = $userData['email'];

            // Добавляем пользователя в Identity Map
            UserIdentityMap::addUser($user);

            $users[] = $user;
        }

        $result->free();

        return $users;
    }
}
