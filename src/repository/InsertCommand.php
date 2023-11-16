<?php

namespace src\repository;

use src\extern\ExecuteCommandInterface;
use src\extern\inputFromDB\sqlite3\Sqlite3DataProvider;

class InsertCommand implements ExecuteCommandInterface
{
    private string $userId;
    private string $eventType;
    private string $subscriberType;

    public function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setEventType(string $eventType): self
    {
        $this->eventType = $eventType;
        return $this;
    }

    public function setSubscriberType(string $subscriberType): self
    {
        $this->subscriberType = $subscriberType;
        return $this;
    }

    public function execute(): bool
    {
        return Sqlite3DataProvider::insert(
            $this->userId,
            $this->eventType,
            $this->subscriberType,
        )->execute();
    }
}
