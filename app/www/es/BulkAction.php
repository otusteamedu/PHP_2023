<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use App\Elasticsearch\CommandActionInterface;
use GuzzleHttp\Client as HttpClient;

class BulkAction implements CommandActionInterface
{
    public $data;
    public $response;
    public $error;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function do(): void
    {
        $this->response = $this->sendcURL($this->data);

        if ($this->response->getStatusCode() !== 200) {
            $this->error = 'Error insert bulk data!';
        }
    }

    private function sendcURL($data)
    {
        $client = new HttpClient();
        return $client->post('elasticsearch:9200/_bulk', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $data
        ]);
    }

    public function getMessage(): string
    {
        return 'Insert data success!';
    }

    public function getError(): string | null
    {
        return $this->error;
    }
}
