<?php

namespace Daniel\Pattern;

use PDO;

class UserDataMapper {
    public function __construct(
        private readonly PDO         $pdo,
        private readonly IdentityMap $identityMap
    ) {}

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM users");
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            if ($this->identityMap->has($id)) {
                $users[] = $this->identityMap->get($id);
                continue;
            }

            $user = new User($row['id'], $row['name']);
            $this->identityMap->set($user);
            $users[] = $user;
        }

        return $users;
    }
}
