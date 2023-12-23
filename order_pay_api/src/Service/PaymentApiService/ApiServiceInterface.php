<?php

declare(strict_types=1);

interface ApiServiceInterface
{
    public function sendRequest(array $data): int;
}
