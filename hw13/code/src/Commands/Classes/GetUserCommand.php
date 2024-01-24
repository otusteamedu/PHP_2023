<?php

namespace Gkarman\Datamaper\Commands\Classes;

use Gkarman\Datamaper\Models\User\UserMapper;

class GetUserCommand extends AbstractCommand
{
    public function run(): string
    {
        $user = (new UserMapper($this->pdo))->findById(1);
        return $user->fullUserInfo();
    }
}
