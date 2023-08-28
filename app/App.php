<?php

namespace App;

use CurlHandle;

class App
{
    /** @var string  */
    protected string $api;

    /** @var CurlHandle|bool  */
    protected bool|CurlHandle $curl;

    /** @var string  */
    protected string $method;

    /** @var null|string  */
    protected ?string $apiKey;

    /** @var string  */
    protected string $contentType;

    public function __construct(
        string $api = 'https://api.siterelic.com/dnsrecord',
        string $method = 'POST',
        string $contentType = 'application/json'
    ) {
        $this->api = $api;
        $this->curl = curl_init($this->api);
        $this->method = $method;
        $this->apiKey = $_ENV['API_KEY'] ?? null;
        $this->contentType = $contentType;
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
     * @see https://siterelic.com/docs#getting-started
     * @param string $email
     * @return bool
     */
    protected function checkMXRecord(string $email): bool
    {
        $data = [
            'url' => $email
        ];
        $curl = $this->curl;
        $this->curlSetOpt($curl, $data);
        $result = $this->curlExec($curl);

        if (isset($result['data']['MX'])) {
            return true;
        }

        return false;
    }

    /**
     * @param CurlHandle $curl
     * @param array $data
     * @return void
     */
    protected function curlSetOpt(CurlHandle $curl, array $data): void
    {
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: ' . $this->contentType,
                'Content-Length: ' . mb_strlen($payload),
                'x-api-key: ' . $this->apiKey,
            ]
        );
    }

    /**
     * @param CurlHandle $curl
     * @return array
     */
    protected function curlExec(CurlHandle $curl): array
    {
        return json_decode(curl_exec($curl), true);
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

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }
}
