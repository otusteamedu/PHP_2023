<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use App\Elasticsearch\CommandActionInterface;
use App\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class DeleteIndexAction implements CommandActionInterface
{
    public $indexName;
    public $response;
    public $error;

    public function __construct($indexName)
    {
        $this->indexName = $indexName;
    }

    public function do(): void
    {
        $client = Client::connect();
        $params = [
            'index' => $this->indexName
        ];

        try {
            $this->response = $client->indices()->delete($params);
        } catch (ClientResponseException $e) {
            $this->error = $e->getMessage();
        } catch (ServerResponseException $e) {
            $this->error = $e->getMessage();
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    public function getMessage(): string
    {
        return 'Index [' . $this->indexName . '] deleted successfully';
    }

    public function getError(): string | null
    {
        return $this->error;
    }
}
