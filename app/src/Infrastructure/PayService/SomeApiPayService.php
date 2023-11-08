<?php

namespace App\Infrastructure\PayService;

class SomeApiPayService
{
    public function sendRequest()
    {
        $ch = curl_init('http://127.0.0.1:9501');
        curl_exec($ch);

        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
}
