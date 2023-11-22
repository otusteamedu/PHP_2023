<?php

namespace src\domain\entry;

use src\infrastructure\extern\FetchDataQueryInterface;
use src\infrastructure\extern\inputFromDB\LinkDBData;
use src\infrastructure\extern\inputStaticStructure\LinkStaticArrayData;

class Repository
{
    private FetchDataQueryInterface $fetcher;

    public function __construct()
    {
        $this->fetcher = new LinkDBData();
        //$this->fetcher = new LinkStaticArrayData();
    }

    public function getAll(): array
    {
        return $this->fetcher->fetchAll();
    }

    public function getUserSubscribes(): array
    {
        return $this->fetcher->fetchUserSubscribes();
    }

    public function getNotify(): array
    {
        return $this->fetcher->fetchNotify();
    }

    public function getEvent(): array
    {
        return $this->fetcher->fetchEvent();
    }

    public function getUsers(): array
    {
        return $this->fetcher->fetchUsers();
    }
}
