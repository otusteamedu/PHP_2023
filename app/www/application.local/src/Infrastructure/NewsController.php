<?php

declare(strict_types=1);

namespace AYamaliev\hw13\Infrastructure;

use AYamaliev\hw13\Application\DataMapper\NewsMapper;
use AYamaliev\hw13\Application\Dto\NewsDto;
use AYamaliev\hw13\Domain\IdentityMap\IdentityMap;
use AYamaliev\hw13\Domain\News;

class NewsController
{
    public \PDO $pdo;
    public IdentityMap $identityMap;
    public NewsMapper $newsMapper;

    public function __construct($connection)
    {
        $this->identityMap = new IdentityMap();
        $this->pdo = $connection;
        $this->newsMapper = new NewsMapper($this->pdo, $this->identityMap);
    }

    public function getAll(): array
    {
        return $this->newsMapper->getAll();
    }

    public function getById(int $id): ?News
    {
        return $this->newsMapper->findById($id);
    }

    public function deleteById(int $id): bool
    {
        $news = $this->newsMapper->findById($id);
        return $this->newsMapper->delete($news);
    }

    public function add(NewsDto $newsDto): News
    {
        return $this->newsMapper->insert([
            'title' => $newsDto->getTitle(),
            'text' => $newsDto->getText(),
            'image' => $newsDto->getImage(),
            'created_at' => $newsDto->getCreatedAt(),
        ]);
    }
}
