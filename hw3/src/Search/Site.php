<?php
declare(strict_types=1);

namespace VyacheslavShabanov\Parsing\Search;

use GuzzleHttp\Client;

class Site
{
    const SITE = 'https://google.com/search';
    private string $query;
    private Client $client;

    public function __construct(string $query)
    {
        $this->client = new Client();
        $this->query = $query;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run(): string
    {
        try {
            $response = $this->client->request('GET', self::SITE, [
                'query' => [
                    'search' => $this->query,
                ],
            ]);
            return $response->getBody()->getContents();
        } catch (\Exception $exception) {
            return 'Произошла ошибка: ' . $exception->getMessage();
        }
    }
}
