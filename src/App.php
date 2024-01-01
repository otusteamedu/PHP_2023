<?php

namespace DanielPalm\Library;

class App
{
    public function run()
    {
// Load environment and settings
        $config = new Configuration(__DIR__);
        $config->loadEnv();

// Create Elasticsearch client
        $esClientWrapper = new ElasticsearchClientWrapper($config);
        $client = $esClientWrapper->buildClient();

        $indexManager = new IndexManager($client);
        $result = $indexManager->findHistoricalNovelsUnder2000WithStock("рыЦори", "поррручика");
        print_r($result);
    }
}