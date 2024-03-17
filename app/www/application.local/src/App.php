<?php

declare(strict_types=1);

namespace AYamaliev\hw13;

use AYamaliev\hw13\DataMapper\NewsMapper;
use AYamaliev\hw13\Db\Connection;
use AYamaliev\hw13\IdentityMap\IdentityMap;

class App
{
    public \PDO $pdo;
    public IdentityMap $identityMap;

    public function __construct()
    {
        $this->identityMap = new IdentityMap();
        $this->pdo = Connection::get()->connect();

        if (!$this->checkExistTable()) {
            $this->createTable();
            $this->insertInitData();
        }
    }

    public function run()
    {
        $newsMapper = new NewsMapper($this->pdo, $this->identityMap);
        $newNews = $newsMapper->insert(['title' => 'Новая новость', 'text' => 'Текст новой новости', 'image' => 'image_new.jpg', 'created_at' => '2024-03-16 19:52:32.071553']);
        $newNews->setTitle('Еще одно название');
        $newsMapper->delete($newNews);
    }

    private function checkExistTable()
    {
        $sql = "SELECT EXISTS (
                    SELECT 1
                    FROM information_schema.tables
                    WHERE table_schema = 'public'
                        AND table_name = 'news'
                )";

        $query = $this->pdo->prepare($sql);
        $query->execute();

        return $query->fetchColumn();
    }

    private function createTable(): void
    {
        $sql = 'CREATE TABLE news
                (
                    id         serial       not null
                        constraint users_pkey
                            primary key,
                    title      varchar(255) not null,
                    text       text         not null,
                    image      varchar(255) not null,
                    created_at timestamp    not null
                );';

        $query = $this->pdo->prepare($sql);
        $result = $query->execute();

        if (!$result) {
            throw new \PDOException('Could not create news table');
        }
    }

    private function insertInitData()
    {
        $newsData = [
            ['title' => 'Заголовок новости 1', 'text' => 'Текст новости 1', 'image' => 'image1.jpg', 'created_at' => '2024-03-16 19:52:32.071553'],
            ['title' => 'Заголовок новости 2', 'text' => 'Текст новости 2', 'image' => 'image2.jpg', 'created_at' => '2024-03-16 19:52:32.071553'],
            ['title' => 'Заголовок новости 3', 'text' => 'Текст новости 3', 'image' => 'image3.jpg', 'created_at' => '2024-03-16 19:52:32.071553'],
        ];

        $sql = 'INSERT INTO news (title, text, image, created_at) VALUES (:title, :text, :image, :created_at)';
        $query = $this->pdo->prepare($sql);

        foreach ($newsData as $news) {
            $query->bindValue('title', $news['title']);
            $query->bindValue('text', $news['text']);
            $query->bindValue('image', $news['image']);
            $query->bindValue('created_at', $news['created_at']);

            try {
                $query->execute();
            } catch (\PDOException $e) {
                var_dump("Error with {$news['title']}: {$e->getMessage()}");
                continue;
            }
        }
    }
}
