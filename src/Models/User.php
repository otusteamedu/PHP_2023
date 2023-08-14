<?php

declare(strict_types=1);

namespace Ro\Php2023\Models;

use Ro\Php2023\DataMapper\UserDataMapperInterface;

class User {
    private int $id;
    private string $username;
    private string $email;
    private ?array $posts = null;
    private UserDataMapperInterface $userDataMapper;

    public function __construct(int $id, string $username, string $email, UserDataMapperInterface $userDataMapper) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->userDataMapper = $userDataMapper;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPosts(): array {
        if ($this->posts === null) {
            $this->posts = $this->userDataMapper->fetchPostsForUser($this->id);
        }
        return $this->posts;
    }
}
