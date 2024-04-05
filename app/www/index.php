<?php

use App\MainElasticsearch;

require __DIR__ . '/vendor/autoload.php';

try {

    $mainElasticsearch = new MainElasticsearch();

    if($argv[1] == 'createIndex'){
        $mainElasticsearch->createIndex();
        $mainElasticsearch->bulkData();
    }elseif ($argv[1] == 'allData'){
        $mainElasticsearch->getAllData();
    }elseif ($argv[1] == 'search'){
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
        //php index.php search "title=рыцОри" "category=Исторический роман" "minPrice=0" "maxPrice=2000"

        $mainElasticsearch->searchData($title, $category, $minPrice, $maxPrice);
    }


} catch (\Exception $e) {
    echo 'Произошла ошибка при выполнении программы!' . PHP_EOL .
        'Текст ошибки: ' . $e->getMessage() . PHP_EOL .
        $e->getTraceAsString();
}

