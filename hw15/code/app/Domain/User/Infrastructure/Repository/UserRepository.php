<?php

namespace App\Domain\User\Infrastructure\Repository;

use App\Domain\User\Domain\Model\User;
use App\Domain\User\Domain\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        DB::table('users')->insert([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ]);
    }

    public function findById(string $id): ?User
    {
        $row = DB::table('users')->where('id', $id)->first();

        if ($row === null) {
            return null;
        }

        return new User($row->name, $row->email);
    }

    public function findByEmail(string $email): ?User
    {
        $row = DB::table('users')->where('email', $email)->first();

        if ($row === null) {
            return null;
        }

        return new User($row->name, $row->email);
    }
}
