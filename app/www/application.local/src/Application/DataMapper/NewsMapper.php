<?php

declare(strict_types=1);

namespace AYamaliev\hw13\Application\DataMapper;

use AYamaliev\hw13\Domain\IdentityMap\IdentityMap;
use AYamaliev\hw13\Domain\News;
use PDO;
use PDOStatement;

class NewsMapper
{
    private PDOStatement $selectOneStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $deleteStatement;

    public function __construct(private PDO $pdo, private IdentityMap $identityMap)
    {
        $this->selectOneStatement = $pdo->prepare(
            'SELECT * FROM news WHERE id = ?'
        );
        $this->selectAllStatement = $pdo->prepare(
            'SELECT * FROM news'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO news (title, text, image, created_at) VALUES (?, ?, ?, ?)'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM news WHERE id = ?'
        );
    }

    public function findById(int $id): ?News
    {
        $model = $this->identityMap->get(News::class, $id);

        if ($model) {
            return $model;
        }

        $this->selectOneStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectOneStatement->execute([$id]);

        $result = $this->selectOneStatement->fetch();

        if (!$result) {
            return null;
        }

        $model = new News(
            $result['id'],
            $result['title'],
            $result['text'],
            $result['image'],
            $result['created_at'],
        );

        $this->identityMap->set($model);

        return $model;
    }

    public function findByIdFromDb(int $id): ?News
    {
        $this->selectOneStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectOneStatement->execute([$id]);

        $result = $this->selectOneStatement->fetch();

        if (!$result) {
            return null;
        }

        return new News(
            $result['id'],
            $result['title'],
            $result['text'],
            $result['image'],
            $result['created_at'],
        );
    }

    public function getAll(): array
    {
        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute();
        $newsRaw = $this->selectAllStatement->fetchAll();

        $_news = [];

        foreach ($newsRaw as $itemNewsRaw) {
            $_news[] = new News($itemNewsRaw['id'], $itemNewsRaw['title'], $itemNewsRaw['text'], $itemNewsRaw['image'], $itemNewsRaw['created_at']);
        }

        return $_news;
    }

    public function insert(array $rawNewsData): News
    {
        $this->insertStatement->execute([
            $rawNewsData['title'],
            $rawNewsData['text'],
            $rawNewsData['image'],
            $rawNewsData['created_at'],
        ]);

        $model = new News(
            (int)$this->pdo->lastInsertId(),
            $rawNewsData['title'],
            $rawNewsData['text'],
            $rawNewsData['image'],
            $rawNewsData['created_at'],
        );

        return $this->identityMap->set($model);
    }

    public function update(News $news): News
    {
        $currentNews = $this->findByIdFromDb($news->getId());

        if (!$currentNews) {
            return $this->identityMap->set($news);
        }

        $params = [];
        $_updateStatement = 'UPDATE news SET';

        if ($news->getTitle() !== $currentNews->getTitle()) {
            $_updateStatement .= ' title = ?,';
            $params[] = $news->getTitle();
        }

        if ($news->getText() !== $currentNews->getText()) {
            $_updateStatement .= ' text = ?,';
            $params[] = $news->getText();
        }

        if ($news->getImage() !== $currentNews->getImage()) {
            $_updateStatement .= ' image = ?,';
            $params[] = $news->getImage();
        }

        if ($news->getCreatedAt() !== $currentNews->getCreatedAt()) {
            $_updateStatement .= ' created_at = ?,';
            $params[] = $news->getCreatedAt();
        }

        if (!$params) {
            return $this->identityMap->set($news);
        }

        $_updateStatement = rtrim($_updateStatement, ',');
        $_updateStatement .= ' WHERE id = ?';
        $params[] = $news->getId();

        $statement = $this->pdo->prepare($_updateStatement);
        $statement->execute($params);

        return $this->identityMap->set($news);
    }

    public function delete(News $news): bool
    {
        $this->identityMap->remove($news);

        return $this->deleteStatement->execute([$news->getId()]);
    }
}
