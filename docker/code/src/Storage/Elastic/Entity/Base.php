<?php

namespace IilyukDmitryi\App\Storage\Elastic\Entity;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Exception;
use InvalidArgumentException;
use stdClass;

abstract class Base
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->initIndex();
    }

    protected function initIndex(): void
    {
        if (!$this->indexExist()) {
            $this->createIndex();
        }
    }

    protected function indexExist(): bool
    {
        $response = $this->client->indices()->exists([
            'index' => static::getIndexName(),
        ]);

        if ($response->getStatusCode() === 200) {
            return true;
        }
        return false;
    }

    protected function createIndex(): bool
    {
        $response = $this->client->indices()->create([
            'index' => static::getIndexName(),
            'body' => [
                'settings' => $this->getSettings(),
                'mappings' => $this->getMappings()
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return true;
    }

    abstract protected function getSettings(): array;

    abstract protected function getMappings(): array;

    /**
     * @param int $channelId
     * @return array
     */
    public function findById(string $id): array
    {
        $index = static::getIndexName();

        $params = [
            'index' => $index,
            'id' => $id,
        ];
        try {
            $response = $this->client->get($params);
            if ($arrRes = $response->asArray()) {
                return $arrRes['_source'];
            }
        } catch (ClientResponseException $exception) {
            $responseJson = $exception->getResponse()->getBody();
            $responseArray = json_decode($responseJson, true);
            if ($responseArray['found'] === false) {
                return [];
            } else {
                throw $exception;
            }
        }
        return [];
    }

    abstract protected static function getIndexName(): string;

    /**
     * @param array $filter
     * @return array
     */
    public function find(array $filter, int $size = 50, int $from = 0): array
    {
        $response = $this->search($filter, $size, $from);
        $arrResult = [];
        if (isset($response['hits']['hits'])) {
            $elements = $response['hits']['hits'];
            foreach ($elements as $element) {
                $arrResult[] = $element['_source'];
            }
        }
        return $arrResult;
    }

    protected function search(array $body, int $size = 50, int $from = 0): array
    {
        $index = static::getIndexName();

        if (!$body) {
            $body = [
                'query' => [
                    'match_all' => new stdClass()
                ],
                //'_source' => array_keys($this->getMappings()['properties'])
                '_source' => []
            ];
        }
        if ($size) {
            $body['size'] = $size;
        }
        if ($from) {
            $body['from'] = $from;
        }

        $params = [
            'index' => $index,
            'body' => $body,
        ];

        $response = $this->client->search($params);
        return $response->asArray();
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(string $id, array $data): bool
    {
        if (empty($id)) {
            throw new InvalidArgumentException("Empty key id");
        }
        $params = $data;

        return $this->updateDoc($id, $params);
    }

    protected function updateDoc(mixed $id, array $body): bool
    {
        $index = $this->getIndexName();
        $params = [
            'id' => $id,
            'index' => $index,
            'body' => ['doc' => $body],
        ];
        $res = $this->client->update($params)->asArray();

        if ($res['result'] !== 'updated' && $res['result'] !== 'noop') {
            throw new Exception("Error updated element");
        }
        return true;
    }

    /**
     * @param array $channel
     * @return mixed
     */
    public function add(array $arrFileds): bool
    {
        if (empty($arrFileds['id'])) {
            throw new InvalidArgumentException("Empty key id");
        }
        return $this->addDoc($arrFileds);
    }

    protected function addDoc(array $body): bool
    {
        $index = $this->getIndexName();
        $id = $body['id'];
        unset($body['id']);
        $params = [
            'index' => $index,
            'body' => $body,
            'id' => $id,
        ];
        $res = $this->client->index($params)->asArray();
        if ($res['result'] !== 'created') {
            throw new Exception("Error add element");
        }
        return true;
    }

    public function import(array $documents, bool $clearStorage = false): bool
    {
        if ($clearStorage) {
            $this->deleteIndex();
            if (!$this->createIndex()) {
                echo "Ошибка при создании индекса ";
                return false;
            }
        }
        $actions = [];
        foreach ($documents as $document) {
            $actions[] = [
                'index' => [
                    '_index' => static::getIndexName(),
                    '_id' => $document['id']
                ]
            ];
            unset($document['id']);
            $actions[] = $document;
        }

        $params = [
            'body' => $actions
        ];

        $response = $this->client->bulk($params);

        if ($response['errors']) {
            foreach ($response['items'] as $item) {
                if (isset($item['index']['error'])) {
                    echo "Ошибка при добавлении документа с ID " . $item['index']['_id'] . ": ";
                    echo $item['index']['error']['reason'] . "\n";
                }
            }
            return false;
        }

        return true;
    }

    protected function deleteIndex(): bool
    {
        if ($this->indexExist()) {
            $this->client->indices()->delete(['index' => static::getIndexName()]);
        }
        return true;
    }

    /**
     * @param int $channelId
     * @return mixed
     */
    public function delete(string $id): bool
    {
        if (empty($id)) {
            throw new InvalidArgumentException("Empty key channel_id");
        }
        $params = ['id' => $id];
        return $this->deleteDoc($params);
    }

    protected function deleteDoc(array $params): bool
    {
        if (!$params) {
            return false;
        }
        $index = static::getIndexName();
        $params['index'] = $index;
        $res = $this->client->delete($params);
        return $res->asBool();
    }
}
