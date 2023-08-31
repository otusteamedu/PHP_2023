<?php

declare(strict_types=1);

namespace Gesparo\Hw\Email;

use Gesparo\Hw\Exception\EmailException;

class DomainChecker
{
    private const MX_RECORD_TYPE = 'MX';

    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @throws EmailException
     * @throws \JsonException
     */
    public function check(string $domain): bool
    {
        $apiResponse = $this->makeRequest($domain);

        $this->checkErrorResponse($apiResponse, $domain);

        return $this->checkIsMX($apiResponse);
    }

    /**
     * @throws EmailException
     * @throws \JsonException
     */
    private function makeRequest(string $domain): array
    {
        $curl = curl_init();
        $params = [
            'domain' => $domain,
        ];

        curl_setopt($curl, CURLOPT_URL, 'https://api.api-ninjas.com/v1/dnslookup' . '?' . http_build_query($params));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                "X-Api-Key: $this->apiKey"
            ]
        );

        $response = curl_exec($curl);

        if ($response === false) {
            throw EmailException::failToGetResponseFromTheApi($domain, $curl);
        }

        curl_close($curl);

        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }

    private function checkIsMX(array $response): bool
    {
        foreach ($response as $record) {
            if (array_key_exists('record_type', $record) && $record['record_type'] === self::MX_RECORD_TYPE) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws EmailException
     */
    private function checkErrorResponse(array $response, string $domain): void
    {
        if (array_key_exists('error', $response)) {
            throw EmailException::apiRespondWithError($response['error'], $domain);
        }
    }
}
