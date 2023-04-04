<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Vp\App\Exceptions\FindEntityFailed;
use Vp\App\Message;
use Vp\App\Models\User;
use Vp\App\Result\ResultFind;
use Vp\App\Services\DataBase;
use WS\Utils\Collections\Collection;

class Find
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DataBase::getInstance()->getConnection();
    }

    public function work(?string $id = null): ResultFind
    {
        try {
            if ($id) {
                $result = User::find($id);
            } else {
                $result = User::all();
            }
            return new ResultFind(true, $this->getMessage($result), $result);
        } catch (FindEntityFailed $e) {
            return new ResultFind(false, Message::FAILED_READ_ENTITY . ': ' . $e->getMessage());
        }
    }

    private function getMessage(Collection $collection): string
    {
        return $collection->isEmpty() ? Message::EMPTY_DATA : Message::SUCCESS_DATA;
    }
}
