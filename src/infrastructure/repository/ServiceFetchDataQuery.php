<?php

namespace src\infrastructure\repository;

use src\infrastructure\extern\FetchDataQueryInterface;
use src\infrastructure\extern\inputFromDB\LinkDBData;

class ServiceFetchDataQuery implements FetchDataQueryInterface
{
    private string $userId;
    private string $eventType;

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

    public function fetchData(): array
    {
        $serviceQuery = new LinkDBData();
        return $serviceQuery->fetchData(
            $this->userId,
            $this->eventType,
        );
    }
}
