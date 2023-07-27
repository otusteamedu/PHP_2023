<?php

namespace App\Model;

/**
 * User identity map
 */
class UserIdentityMap
{
    /**
     * Users
     *
     * @var array
     */
    private static $users = [];

    /**
     * Get user by id.
     *
     * @param int $id User id
     *
     * @return User|null
     */
    public static function getUser($id)
    {
        return isset(self::$users[$id]) ? self::$users[$id] : null;
    }

    /**
     * Add user to identity map.
     *
     * @param User $user User
     *
     * @return void
     */
    public static function addUser(User $user)
    {
        self::$users[$user->id] = $user;
    }

    /**
     * Get all users.
     *
     * @return array
     */
    public static function getAllUsers()
    {
        return self::$users;
    }
}
