<?php

declare(strict_types=1);

namespace AYamaliev\hw13\DataMapper;

use AYamaliev\hw13\IdentityMap\IdentityMap;
use PDO;
use PDOStatement;

class NewsMapper
{
    private PDOStatement $selectOneStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
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
        $this->updateStatement = $pdo->prepare(
            'UPDATE news SET title = ?, text = ?, image = ?, created_at = ? WHERE id = ?'
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
        $this->updateStatement->execute([
            $news->getTitle(),
            $news->getText(),
            $news->getImage(),
            $news->getCreatedAt(),
            $news->getId(),
        ]);

        return $this->identityMap->set($news);

    }

    public function delete(News $news): bool
    {
        $this->identityMap->remove($news);

        return $this->deleteStatement->execute([$news->getId()]);
    }
}
