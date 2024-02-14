<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\App\ElasticService;
use Klobkovsky\App\Exceptions\DocumentCreateException;
use Klobkovsky\App\Exceptions\DocumentSearchException;
use Klobkovsky\App\Exceptions\IndexCreateException;
use Klobkovsky\App\Exceptions\IndexDeleteException;
use \Klobkovsky\App\Model\OtusShopEntity;

$flag = -1;
$price = 0;
$category = '';
$title = '';

$elasticService = new ElasticService(new OtusShopEntity());

do {
    $flag = (int)readline('To delete an index, type 1, to create an index, type 2, to create a document, type 3, to search books, type 4: ');

    switch ($flag) {
        case 1:
            try {
                $elasticService->deleteIndex();
            } catch (IndexDeleteException $e) {
                echo $e->getMessage();
            }

            echo 'Index ' . $elasticService->getIndexName() . ' successfully delete';
            break;
        case 2:
            try {
                $elasticService->createIndex();
            } catch (IndexCreateException $e) {
                echo $e->getMessage();
            }

            echo 'Index ' . $elasticService->getIndexName() . ' successfully create';
            break;
        case 3:
            try {
                $elasticService->createDocument();
            } catch (DocumentCreateException $e) {
                echo $e->getMessage();
            }

            echo 'Document successfully create';
            break;
        case 4:
            $category = (string)readline('Enter book category: ');
            $price = (int)readline('Enter max book price: ');
            $title = (string)readline('Enter book title: ');

            try {
                $result = $elasticService->searchDocument($title, $category, $price);
                print_r($result['hits']['hits']);
            } catch (DocumentSearchException $e) {
                echo $e->getMessage();
            }
            break;
    }
} while ($flag !== 0 && $flag !== 1 && $flag !== 2 && $flag !== 3);
