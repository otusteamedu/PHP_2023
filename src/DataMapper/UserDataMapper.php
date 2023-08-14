<?php

declare(strict_types=1);

namespace Ro\Php2023\DataMapper;

use PDO;
use Ro\Php2023\Models\User;

class UserDataMapper implements UserDataMapperInterface {
    private PDO $db_connection;
    private UserIdentityMap $userIdentityMap;

    public function __construct(PDO $db_connection, UserIdentityMap $userIdentityMap) {
        $this->db_connection = $db_connection;
        $this->userIdentityMap = $userIdentityMap;
    }

    public function fetchAllUsers(): array {
        $query = "SELECT * FROM users";
        $result = $this->db_connection->query($query);
        $users = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['id'], $row['username'], $row['email'], $this);
            $this->userIdentityMap->addUser($user);
            $users[] = $user;
        }
        return $users;
    }

    public function fetchPostsForUser(int $user_id): array {
        $query = "SELECT * FROM user_posts WHERE user_id = ?";
        $stmt = $this->db_connection->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser(string $username, string $email): bool {
        $query = "INSERT INTO users (username, email) VALUES (?, ?)";
        $stmt = $this->db_connection->prepare($query);
        return $stmt->execute([$username, $email]);
    }

    public function updateUser(int $user_id, string $username, string $email): bool {
        $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $this->db_connection->prepare($query);
        return $stmt->execute([$username, $email, $user_id]);
    }

    public function deleteUser(int $user_id): bool {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db_connection->prepare($query);
        return $stmt->execute([$user_id]);
    }

    public function getUserById(int $user_id): ?User {
        $cachedUser = $this->userIdentityMap->getUserById($user_id);
        if ($cachedUser) {
            return $cachedUser;
        }

        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db_connection->prepare($query);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $user = new User($row['id'], $row['username'], $row['email'], $this);
        $this->userIdentityMap->addUser($user);

        return $user;
    }
}
