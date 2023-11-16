<?php

namespace src\extern;

interface FetchDataArrayInterface
{
    public function fetchData(string $userId, string $eventType): array;
}
