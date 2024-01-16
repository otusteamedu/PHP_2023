<?php

namespace DataMapper;

use PDO;

class UserMapper
{
    private $database;
    private $identityMap;

    public function __construct(PDO $database, IdentityMap $identityMap) {
        $this->database = $database;
        $this->identityMap = $identityMap;
    }


    public function findById($id) {
        /**
         * @deprecated Identity Map
         */
        if ($object = $this->identityMap->get($id)) {
            return $object;
        }

        $stmt = $this->database->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if ($row === false) {
            return new UserNull();
        }

        $user = new User($row['id'], $row['username'], $row['email']);
        $this->identityMap->add($id, $user);
        return $user;
    }
}