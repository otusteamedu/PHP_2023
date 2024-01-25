<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Dimal\Hw13\News;

$conf = parse_ini_file(".env");

$pdo = new PDO("pgsql:host=$conf[HOST];dbname=$conf[DBNAME]", $conf['USER'], $conf['PASSWORD']);

//create TableGateway object
$newsTableGw = new News($pdo);

//add news item
$news_item_id = $newsTableGw->insert("title", "author", "2023-01-02", "text", 'category');

//get news item
$news_object = $newsTableGw->getById($news_item_id);

//update news item
$newsTableGw->update(
    $news_item_id,
    [
        'title' => 'new titlez!',
        'content' => 'This is a new text',
        'date' => '2023-12-12'
    ]
);

//delete news item by id
$newsTableGw->delete($news_item_id);
