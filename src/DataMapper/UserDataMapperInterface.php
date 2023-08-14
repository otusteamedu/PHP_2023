<?php

declare(strict_types=1);

namespace Ro\Php2023\DataMapper;

use Ro\Php2023\Models\User;

interface UserDataMapperInterface {
    public function fetchAllUsers(): array;
    public function fetchPostsForUser(int $user_id): array;
    public function createUser(string $username, string $email): bool;
    public function updateUser(int $user_id, string $username, string $email): bool;
    public function deleteUser(int $user_id): bool;
    public function getUserById(int $user_id): ?User;
}
