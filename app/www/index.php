<?php

use App\MainElasticsearch;

require __DIR__ . '/vendor/autoload.php';

try {
    $client = new MainElasticsearch();

    // Формируем запрос к Elasticsearch
    $params = [
        'index' => 'otus-shop',
        'body' => [
            'query' => [
                'match' => [
                    'title' => 'Кто подставил поручика Ржевского на Луне'
                ]
            ]
        ]
    ];

    // Выполняем запрос к Elasticsearch
    $response = $client->search($params);

    // Обрабатываем результаты запроса
    $hits = $response['hits']['hits'];
    foreach ($hits as $hit) {
        echo $hit['_source']['title'] . '<br>'; // Выводим найденные заголовки книг
    }

//    $searchDto = new SearchDto($argv);
//
//    ((new SearchBooks($client))($searchDto));
} catch (\Exception $e) {
    echo $e->getMessage();
}


//try {
//    // Создаем клиент Elasticsearch
////    $client = ClientBuilder::create()
////        ->setHosts(['https://localhost:9200'])
////        ->setSSLVerification(false)
////        ->setBasicAuthentication('elastic', 'elastic123')
////        ->build();
//
//    // Загружаем содержимое файла books.json
//    $booksData = file_get_contents(__DIR__ . '/books.json');
//    $books = json_decode($booksData, true);
//
//
//
//
//
//
//    // Формируем запрос к Elasticsearch
//    $params = [
//        'index' => 'otus-shop', // Имя индекса Elasticsearch
//        'body' => [
//            'query' => [
//                'bool' => [
//                    'should' => []
//                ]
//            ],
//            'size' => 10 // Указываем количество возвращаемых документов (книг)
//        ]
//    ];
//
//    // Добавляем условия поиска для каждой книги из файла books.json
//    foreach ($books as $book) {
//        $params['body']['query']['bool']['should'][] = [
//            'match' => [
//                'title' => $book['title']
//            ]
//        ];
//    }
//
//    // Выполняем запрос к Elasticsearch
//    $response = $client->search($params);
//
//    // Обрабатываем результаты запроса
//    $hits = $response['hits']['hits'];
//    foreach ($hits as $hit) {
//        echo $hit['_source']['title'] . '<br>'; // Выводим найденные заголовки книг
//    }
//} catch (\Exception $e) {
//    echo $e->getMessage();
//}

