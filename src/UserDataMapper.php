<?php

namespace Daniel\Pattern;

use PDO;

class UserDataMapper {
    public function __construct(
        private readonly PDO         $pdo,
        private readonly IdentityMap $identityMap
    ) {}

    public function findAll(?int $lastId = null, int $pageSize = 10): array {
        if ($lastId) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id > :lastId ORDER BY id ASC LIMIT :limit");
            $stmt->bindParam(':lastId', $lastId, PDO::PARAM_INT);
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY id ASC LIMIT :limit");
        }

        $stmt->bindParam(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->execute();

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
