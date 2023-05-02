#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

use App\Models\Book;
use App\Repositories\BookRepository;

$jsonData = file_get_contents(__DIR__ . '/books.json');

if ($jsonData === false) {
    die("Error reading books.json");
}

// Parse the JSON data into an array of lines (JSON objects)
$dataLines = explode("\n", $jsonData);

// Create instances of the Book model from the data lines
$books = [];
foreach ($dataLines as $i => $dataLine) {
    if ($i % 2 === 1) {
        $data = json_decode($dataLine, true);

        $books[] = new Book(
            $data['sku'],
            $data['title'],
            $data['category'],
            $data['price'],
            $data['stock']
        );
    }
}

// Use the BookRepository's indexBooks method to index the book instances into Elasticsearch
$bookRepository = new BookRepository();
$bookRepository->indexBooks($books);

echo "Books imported successfully.\n";
