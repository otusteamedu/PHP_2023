<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\User;

interface UserMapperInterface
{
    public function findById(int $id): User;
    public function findByLogin(string $login): User;
    public function insert(User $user): void;
    public function update(User $user): bool;
    public function delete(User $user): bool;
}
