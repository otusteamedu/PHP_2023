<?php

namespace App\Model;

class UserIdentityMap
{
    private static $users = [];

    public static function getUser($id)
    {
        return isset(self::$users[$id]) ? self::$users[$id] : null;
    }

    public static function addUser(User $user)
    {
        self::$users[$user->id] = $user;
    }

    public static function getAllUsers()
    {
        return self::$users;
    }
}
