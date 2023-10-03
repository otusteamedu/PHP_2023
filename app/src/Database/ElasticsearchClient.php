<?php

namespace App\Database;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchClient {
    public function getClient() {
        return ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
    }
}