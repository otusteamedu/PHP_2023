<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use App\Elasticsearch\CommandActionInterface;
use App\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use Models\BookStoreModel;

class CreateIndexAction implements CommandActionInterface
{
    public $indexName;
    public $response;
    public $error;

    public function do(): void
    {
        $client = Client::connect();
        $params = [
            'index' => BookStoreModel::INDEX_NAME,
            'body' => [
                'mappings' => BookStoreModel::getMappings(),
                'settings' => BookStoreModel::getSettings()
            ]
        ];

        try {
            $this->response = $client->index($params);
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
        $response = $this->response->asArray();

        return 'Index [' . $response['_index'] . '] created successfully';
    }

    public function getError(): string | null
    {
        return $this->error;
    }
}
