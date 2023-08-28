<?php

namespace App;

use CurlHandle;

class App
{
    /** @var string  */
    private string $api;

    /** @var CurlHandle|bool  */
    private bool|CurlHandle $curl;

    /** @var string  */
    private string $method;

    /** @var null|string  */
    private ?string $apiKey;

    public function __construct(string $api = 'https://api.siterelic.com/dnsrecord', string $method = 'POST')
    {
        $this->api = $api;
        $this->curl = curl_init($this->api);
        $this->method = $method;
        $this->apiKey = $_ENV['API_KEY'] ?? null;
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    /**
     * @param array $list
     * @return array
     */
    public function validateEmails(array $list): array
    {
        return array_filter($list, function ($item) {
            return filter_var($item, FILTER_VALIDATE_EMAIL)
                && $this->checkMXRecord($item);
        });
    }

    /**
     * @param string $email
     * @return bool
     */
    private function checkMXRecord(string $email): bool
    {
        $data = [
            'url' => $email
        ];
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $curl = $this->curl;

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . mb_strlen($payload),
            'x-api-key: ' . 'e964950a-f041-409f-bb01-fbc98917099f',
            ]
        );

        $result = curl_exec($curl);

        if (isset($result['data']['MX'])) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getApi(): string
    {
        return $this->api;
    }

    /**
     * @param string $api
     */
    public function setApi(string $api): void
    {
        $this->api = $api;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * @param string|null $apiKey
     */
    public function setApiKey(?string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }
}
