<?php

use App\DocumentCreator;
use App\DocumentSearcher;
use App\ElasticSearchCommonService;
use App\Exceptions\DocumentCreateException;
use App\Exceptions\IndexCreateException;
use App\Exceptions\IndexDeleteException;
use App\IndexCreator;
use App\IndexDeleter;

require __DIR__ . '/vendor/autoload.php';

$flag = -1;
$price = 0;
$category = '';
$title = '';
$indexName = 'otus-shop';

do {
    $flag = (int)readline('To delete an index, type 1, to create an index, type 2, to create a document, type 3, to search books, type 4: ');

    switch ($flag) {
        case 1:
            try {
                $indexDeleter = new IndexDeleter(new ElasticSearchCommonService());
                $indexDeleter->execute($indexName);
            } catch (IndexDeleteException $e) {
                echo $e->getMessage();
            }

            echo 'Index ' . $indexName . ' successfully delete';
            break;
        case 2:
            try {
                $indexCreator = new IndexCreator(new ElasticSearchCommonService());
                $indexCreator->execute($indexName);
            } catch (IndexCreateException $e) {
                echo $e->getMessage();
            }

            echo 'Index ' . $indexName . ' successfully create';
            break;
        case 3:
            try {
                $documentCreator = new DocumentCreator(new ElasticSearchCommonService());
                $documentCreator->execute();
            } catch (DocumentCreateException $e) {
                echo $e->getMessage();
            }

            echo 'Document successfully create';
            break;
        case 4:
            $category = (string)readline('Enter book category: ');
            $price = (int)readline('Enter max book price: ');
            $title = (string)readline('Enter book title: ');
            $documentSearcher = new DocumentSearcher(new ElasticSearchCommonService());
            $result = $documentSearcher->execute($indexName, $title, $category, $price);
            print_r($result['hits']['hits']);
            break;
    }
} while ($flag !== 0 && $flag !== 1 && $flag !== 2 && $flag !== 3);
