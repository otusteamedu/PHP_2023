<?php

declare(strict_types=1);

namespace Gesparo\HW\Mapper;

use Gesparo\HW\Entity\BaseEntity;
use Gesparo\HW\Entity\Film;
use Gesparo\HW\ModelRelation;

class FilmMapper extends BaseMapper
{
    private ScreeningMapper $screeningMapper;

    public function __construct(\PDO $pdo, ScreeningMapper $screeningMapper)
    {
        parent::__construct($pdo);

        $this->screeningMapper = $screeningMapper;
    }

    protected function mapRowToFilm(int $id, array $row): Film
    {
        return new Film(
            $id,
            $row['name'],
            $row['duration'],
            $row['description'],
            $row['actors'],
            $row['country'],
            $row['created_at'],
            $row['updated_at'],
            new ModelRelation($this->screeningMapper, 'findManyByFilmId', [$id])
        );
    }

    protected function getInsertFields(array $raw): array
    {
        return [
            'name' => $raw['name'],
            'duration' => $raw['duration'],
            'description' => $raw['description'],
            'actors' => $raw['actors'],
            'country' => $raw['country'],
            'created_at' => $raw['created_at'],
            'updated_at' => $raw['updated_at'],
        ];
    }

    protected function getUpdateFields(BaseEntity $entity): array
    {
        /** @var Film $entity */
        return [
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'duration' => $entity->getDuration(),
            'description' => $entity->getDescription(),
            'actors' => $entity->getActors(),
            'country' => $entity->getCountry(),
            'created_at' => $entity->getCreatedAt(),
            'updated_at' => $entity->getUpdatedAt(),
        ];
    }

    protected function getSelectStmt(): \PDOStatement
    {
        return $this->pdo->prepare(
            '
            SELECT name, duration, description, actors, country, created_at, updated_at 
            FROM films 
            WHERE id = ? LIMIT 1'
        );
    }

    protected function getInsertStmt(): \PDOStatement
    {
        $sql = <<<SQL
            INSERT INTO films (name, duration, description, actors, country, created_at, updated_at) 
            VALUES (:name, :duration, :description, :actors, :country, :created_at, :updated_at)
        SQL;

        return $this->pdo->prepare($sql);
    }

    protected function getUpdateStmt(): \PDOStatement
    {
        $slq = <<<SQL
            UPDATE films 
            SET 
                name = :name, 
                duration = :duration, 
                description = :description,
                actors = :actors, 
                country = :country, 
                created_at = :created_at, 
                updated_at = :updated_at 
            WHERE id = :id
            LIMIT 1
        SQL;

        return $this->pdo->prepare($slq);
    }

    protected function getDeleteStmt(): \PDOStatement
    {
        return $this->pdo->prepare('DELETE FROM films WHERE id = ? LIMIT 1');
    }

    protected function getSelectManyStmt(): \PDOStatement
    {
        $sql = <<<SQL
            SELECT id, name, duration, description, actors, country, created_at, updated_at 
            FROM films 
            ORDER BY id DESC 
            LIMIT :limit OFFSET :offset
        SQL;

        return $this->pdo->prepare($sql);
    }
}
