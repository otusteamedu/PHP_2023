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
    }

    public function run(): void
    {
        $newsMapper = new NewsMapper($this->pdo, $this->identityMap);
        $newNews = $newsMapper->insert(['title' => 'Новая новость', 'text' => 'Текст новой новости', 'image' => 'image_new.jpg', 'created_at' => '2024-03-16 19:52:32.071553']);
        $newNews->setTitle('Еще одно название');
        $newsMapper->update($newNews);
        $newsMapper->delete($newNews);
    }
}
