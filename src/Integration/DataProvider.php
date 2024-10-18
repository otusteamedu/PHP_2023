<?php

declare(strict_types=1);

namespace src\Integration;

class DataProvider
{
    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct(
        private readonly string $host,
        private readonly string $user,
        private readonly string $password
    ) {
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request): array
    {
        // returns a response from external service
    }
}