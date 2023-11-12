<?php

namespace App\Infrastructure\PayService;

class SomeApiPayService implements SomeApiPayServiceInterface
{
    public function sendRequest(): int
    {
        $ch = curl_init($_ENV['URL']);
        curl_exec($ch);

        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
}
