<?php

namespace src\infrastructure\extern;

interface FetchDataQueryInterface
{
    public function fetchAll(): array;

    public function fetchUserSubscribes(): array;

    public function fetchNotify(): array;

    public function fetchEvent(): array;

    public function fetchUsers(): array;
}
