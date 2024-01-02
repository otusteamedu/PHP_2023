<?php

declare(strict_types=1);

namespace DanielPalm\Library;

use Elastic\Elasticsearch\Exception\AuthenticationException;

class App
{
    /**
     * @throws AuthenticationException
     */
    public function run(array $argv): array
    {
        $config = new Configuration(__DIR__);
        $config->loadEnv();

        $esClientWrapper = new ElasticsearchClientWrapper($config);
        $client = $esClientWrapper->buildClient();

        $indexManager = new IndexManager($client);

        $titleFirst = $argv[1] ?? null;
        $titleSecond = $argv[2] ?? null;
        $indexName = $argv[3] ?? null;
        $category = $argv[4] ?? null;


        if ($titleFirst === null || $titleSecond === null || $indexName = null) {
            fwrite(STDERR, "Two book titles and index name need to be provided as arguments.\n");
            exit(1);
        }

        $parameters = [
            'titleFirst' => $titleFirst,
            'titleSecond' => $titleSecond,
            'index' => $indexName,
            'category' => $category
        ];

        return $indexManager->findNovelsWithOptionalParameters($parameters);
    }
}
