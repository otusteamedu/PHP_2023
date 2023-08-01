<?php

namespace App\Model;

use App\Model\User as User;
use App\Model\UserIdentityMap as UserIdentityMap;

/**
 * User gateway
 */
class UserGateway
{
    /**
     * MySQLi connection
     *
     * @var \mysqli
     */
    private $mysqli;

    /**
     * Constructor
     *
     * @param \mysqli $mysqli MySQLi connection
     *
     * @return void
     */
    public function __construct(\mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * Update user
     *
     * @param int $id User id
     * @param string $name User name
     * @param string $email User email
     *
     * @return bool
     */
    public function update($id, $name, $email)
    {
        // if existing user, update user in Identity Map and database.
        if ($user = UserIdentityMap::getUser($id)) {
            $stmt = $this->mysqli->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $email, $id);
            $user->name = $name;
            $user->email = $email;
            if (!$user->validateFields()) {
                return false;
            }
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        }

        // if new user, add user to database.
        $user = new User();
            $user->name = $name;
            $user->email = $email;
        if (!$user->validateFields()) {
            return false;
        }
        $stmt = $this->mysqli->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    /**
     * Find all users
     *
     * @return array
     */
    public function findAll()
    {
        // Getting all users from Identity Map
        $users = UserIdentityMap::getAllUsers();

        // If users found in Identity Map, return them
        if ($users !== []) {
            return $users;
        }

        // If users not found in Identity Map, find them in database
        $query = "SELECT * FROM users";
        $result = $this->mysqli->query($query);
        $users = [];
        while ($userData = $result->fetch_assoc()) {
            $user = new User();
            $user->id = $userData['id'];
            $user->name = $userData['name'];
            $user->email = $userData['email'];

            // Adding user to Identity Map
            UserIdentityMap::addUser($user);

            $users[] = $user;
        }

        $result->free();

        return $users;
    }
}
