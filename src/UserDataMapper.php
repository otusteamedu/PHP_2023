<?php

namespace Daniel\Pattern;

use PDO;

class UserDataMapper {
    public function __construct(
        private readonly PDO         $pdo,
        private readonly IdentityMap $identityMap
    ) {}

    public function findAll(int $page = 1, int $pageSize = 10): array {
        $offset = ($page - 1) * $pageSize;
        $stmt = $this->pdo->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
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
