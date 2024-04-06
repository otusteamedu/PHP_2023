<?php

use App\ElasticsearchBase;
use App\ElasticsearchStart;
use App\Service\ElasticsearchCleanup;
use App\Service\ElasticsearchService;

require __DIR__ . '/vendor/autoload.php';

try {

    $mainElasticsearch = new ElasticsearchBase();

    if ($argv[1] == 'cleanup'){
        $cleanup = new ElasticsearchCleanup();
        $cleanup->clearIndex();
    }elseif ($argv[1] == 'createIndex'){
        $start = new ElasticsearchStart();
        $start->createIndex();
        $start->bulkData();
    }elseif ($argv[1] == 'allData'){
        $service = new ElasticsearchService();
        $service->allData();
    }elseif ($argv[1] == 'search'){
        $service = new ElasticsearchService();
        $title = null;
        $category = null;
        $minPrice = null;
        $maxPrice = null;

        foreach ($argv as $arg){
            $item = explode("=", $arg);
            if($item[0] == 'title'){
                $title = $item[1];
            }elseif ($item[0] == 'category'){
                $category = $item[1];
            }elseif ($item[0] == 'minPrice'){
                $minPrice = $item[1];
            }elseif ($item[0] == 'maxPrice'){
                $maxPrice = $item[1];
            }
        }

        $service->searchData($title, $category, $minPrice, $maxPrice);
    }


} catch (\Exception $e) {
    echo 'Произошла ошибка при выполнении программы!' . PHP_EOL .
        'Текст ошибки: ' . $e->getMessage() . PHP_EOL .
        $e->getTraceAsString();
}

