<?php

namespace DanielPalm\Library;

class App
{
    public function run()
    {
        $config = new Configuration(__DIR__);
        $config->loadEnv();

        $esClientWrapper = new ElasticsearchClientWrapper($config);
        $client = $esClientWrapper->buildClient();

        $indexManager = new IndexManager($client);

        $titleFirst = $argv[1] ?? "рыЦори";
        $titleSecond = $argv[2] ?? "поррручика";

        $result = $indexManager->findHistoricalNovelsUnder2000WithStock($titleFirst, $titleSecond);
        print_r($result);
    }
}
