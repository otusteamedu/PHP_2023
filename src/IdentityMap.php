<?php
declare(strict_types=1);

namespace Daniel\Pattern;

class IdentityMap {
    private array $identityMap = [];

    public function get(int $id): ?User {
        return $this->identityMap[$id] ?? null;
    }

    public function set(User $user): void {
        $this->identityMap[$user->getId()] = $user;
    }

    public function has(int $id): bool {
        return isset($this->identityMap[$id]);
    }
}
