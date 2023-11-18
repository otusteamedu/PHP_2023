<?php

namespace src\infrastructure\extern;

interface FetchDataArrayInterface
{
    public function fetchData(string $userId, string $eventType): array;
}
