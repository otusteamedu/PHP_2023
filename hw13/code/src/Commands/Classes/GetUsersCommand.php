<?php

namespace Gkarman\Datamaper\Commands\Classes;

use Gkarman\Datamaper\Models\User\UserMapper;

class GetUsersCommand extends AbstractCommand
{
    public function run(): string
    {
        $usersCollection = (new UserMapper($this->pdo))->findAll();
        $users = $usersCollection->getAll();

        $result = [];
        foreach ($users as $user) {
            $result[] = $user->getEmail();
        }
        return implode(', ', $result);
    }
}
