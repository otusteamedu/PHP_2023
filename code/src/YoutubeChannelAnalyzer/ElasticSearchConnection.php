<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw11\YoutubeChannelAnalyzer;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchConnection {
    protected $elasticConnection;

    public function __construct() {
        $this->elasticConnection = ClientBuilder::create()
        ->setHosts(['http://hw11-elasticsearch:9200'])
        ->build();
    }

    public function searchDocument(array $arQueryParams) {
        return $this->elasticConnection->search($arQueryParams)->asArray();
    }

    public function addDocument() {

    }

    public function updateDocument() {

    }

    public function deleteDocument() {

    }

    public function addIndex() {

    }

    public function deleteIndex() {

    }
}
