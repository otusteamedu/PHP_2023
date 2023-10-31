<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function getById(int $id):?User;
    public function add(User $user): int;
    public function update(User $user): void;
    public function delete(int $id): void;
}