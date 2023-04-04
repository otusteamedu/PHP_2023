<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Vp\App\DTO\ParamsAdd;
use Vp\App\Exceptions\AddEntityFailed;
use Vp\App\Message;
use Vp\App\Models\User;
use Vp\App\Result\ResultAdd;
use Vp\App\Services\DataBase;

class Add
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DataBase::getInstance()->getConnection();
    }

    public function work(ParamsAdd $params): ResultAdd
    {
        try {
            $user = new User();
            $user->login = $params->getLogin();
            $user->email = $params->getEmail();
            $user->save();
            return new ResultAdd(true, Message::SUCCESS_ADD);
        } catch (AddEntityFailed $e) {
            return new ResultAdd(false, Message::FAILED_ADD_ENTITY . ': ' . $e->getMessage());
        }
    }
}
