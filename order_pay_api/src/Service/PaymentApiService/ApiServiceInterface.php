<?php

declare(strict_types=1);

namespace App\Service\PaymentApiService;

interface ApiServiceInterface
{
    public function sendRequest(array $data): int;
}
