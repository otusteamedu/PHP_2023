<?php

namespace HW11\Elastic;

class IndexManager extends AbstractElasticSearch
{
    public const INDEX_NAME = 'otus-shop';
    public function createIndex(array $mapping): void
    {
        if ($this->client->indices()->exists(['index' => self::INDEX_NAME])->getStatusCode() === 404) {
            $this->client->indices()->create([
                'index' => self::INDEX_NAME,
                'body' => $mapping,
            ]);
        }
    }
}
