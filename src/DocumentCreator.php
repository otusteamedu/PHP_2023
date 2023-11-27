<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class DocumentCreator
{
    public function __construct(private readonly ElasticSearchClient $elasticSearchClient)
    {
    }

    public function execute(): void
    {
        $file = __DIR__ . '/../../books.json';
        $handle = fopen($file, "r");

        while (!feof($handle)) {
            $line = fgets($handle);

            if (!empty($line)) {
                $document = json_decode($line, true);

                if (isset($document['create'])) {
                    $index = $document['create']['_index'];
                    $id = $document['create']['_id'];
                    $indexAndId = [
                        'index' => $index,
                        'id' => $id
                    ];
                }

                if (isset($document['title'])) {
                    $body = ['body' => $document];
                    $param = array_merge($indexAndId, $body);

                    try {
                        $this->elasticSearchClient->getClient()->index($param);
                    } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }

        fclose($handle);
    }
}