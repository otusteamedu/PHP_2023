<?php

use Sva\BookShop\Infrastructure\Elastic\Index;
use Sva\BookShop\Infrastructure\Elastic\FilterFactory;
use Sva\BookShop\Infrastructure\Elastic\ResultConsolePresenter;

return [
    'create-index' => function () {
        $index = new Index();

        try {
            $index->create();
            echo 'Индекс успешно создан' . "\n";
        } catch (Exception $exception) {
            echo 'Ошибка при создании индекса: ' . $exception->getMessage() . "\n";
        }
    },
    'delete-index' => function () {
        $index = new Index();

        try {
            $index->deleteIndex();
            echo 'Индекс успешно удален' . "\n";
        } catch (Exception $exception) {
            echo 'Ошибка при удалении индекса: ' . $exception->getMessage() . "\n";
        }
    },
    'load-data' => function () {
        $index = new Index();

        try {
            $index->loadData();
            echo 'Данные успешно загружены' . "\n";
        } catch (Exception $exception) {
            echo 'Ошибка при загрузке данных: ' . $exception->getMessage() . "\n";
        }
    },
    'search' => function ($args) {
        $filter = FilterFactory::fromArgs($args);
        $index = new Index();

        try {
            $arResult = $index->search($filter);
            $presenter = new ResultConsolePresenter();
            $presenter->print($arResult);
        } catch (Exception $exception) {
            echo 'Ошибка при поиске: ' . $exception->getMessage() . "\n";
        }
    }
];
