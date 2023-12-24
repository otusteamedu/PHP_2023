<?php

declare(strict_types=1);

namespace App\Service\PaymentApiService;

class PaymentApiService implements ApiServiceInterface
{
    public function sendRequest(array $data): int
    {
        $ch = curl_init(getenv('URL'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);

        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
}
