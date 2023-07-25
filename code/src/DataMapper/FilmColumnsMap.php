<?php

declare(strict_types = 1);

namespace VKorabelnikov\Hw13\DataMapper;

class FilmColumnsMapper
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $selectPdoStatement;

    /**
     * @var \PDOStatement
     */
    private $insertPdoStatement;

    /**
     * @var \PDOStatement
     */
    private $updatePdoStatement;

    /**
     * @var \PDOStatement
     */
    private $deletePdoStatement;

    /**
     * @var \PDOStatement
     */
    private $getAllPdoStatement;

    /**
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectPdoStatement = $pdo->prepare(
            "SELECT name, duration, cost FROM films WHERE id = :id"
        );

        $this->insertPdoStatement = $pdo->prepare(
            "INSERT INTO films (name, duration, cost) VALUES (:id, :name, :duration, :cost)"
        );

        $this->updatePdoStatement = $pdo->prepare(
            "UPDATE films SET name = :name, duration = :duration, cost = :cost WHERE id = :id"
        );

        $this->deletePdoStatement = $pdo->prepare("DELETE FROM films WHERE id = :id");

        $this->getAllPdoStatement = $pdo->prepare("SELECT id, name, duration, cost FROM films ORDER BY :order_field LIMIT :limit OFFSET :offset");
    }

    /**
     * @param int $id
     *
     * @return Film
     */
    public function findById(int $id): Film
    {
        $this->selectPdoStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectPdoStatement->execute(['id' => $id]);
        $filmParams = $this->selectPdoStatement->fetch();

        return new Film(
            $id,
            $filmParams['name'],
            $filmParams['duration'],
            $filmParams['cost']
        );
    }

    /**
     * @param array $arFilmParams
     *
     * @return Film
     */
    public function insert(array $filmParams): Film
    {
        $this->insertPdoStatement->execute(
            [
                'name' => $filmParams['name'],
                'duration' => $filmParams['duration'],
                'cost' => $filmParams['cost']
            ]
        );

        return new Film(
            (int) $this->pdo->lastInsertId(),
            $filmParams['name'],
            $filmParams['duration'],
            $filmParams['cost']
        );
    }

    /**
     * @param Film $film
     *
     * @return bool
     */
    public function update(Film $film): bool
    {
        return $this->updatePdoStatement->execute(
            [
                'id' => $film->getId(),
                'name' => $film->getName(),
                'duration' => $film->getDuration(),
                'cost' => $film->getCost()
            ]
        );
    }

    /**
     * @param Film $film
     *
     * @return bool
     */
    public function delete(Film $film): bool
    {
        return $this->deletePdoStatement->execute(['id' => $film->getId()]);
    }

    /**
     * @param Film $film
     *
     * @return FilmsCollection
     */
    public function getAll(string $orderBy = 'id', int $limit = 100, int $offset = 0): FilmsCollection
    {
        // $queryOrder = (!empty($orderBy)? $orderBy: 'id');
        // $queryLimit = (!empty($limit)? $limit: '100');
        // $queryOffset = (!empty($offset)? $offset: '0');

        $this->selectPdoStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->getAllPdoStatement->execute(
            [
                'order_field' => $orderBy,
                'limit' => $limit,
                'offset' => $offset
            ]
        );
        $filmsDbResult = $this->selectPdoStatement->fetch();

        $filmsCollection = new FilmsCollection();
        $collectionIndex = 0;
        foreach($filmsDbResult as $filmProps)
        {
            $filmsCollection->set(
                $collectionIndex,
                new Film(
                    (int) $filmProps['id'],
                    $filmProps['name'],
                    $filmProps['duration'],
                    $filmProps['cost']
                )
            );

            $collectionIndex++;
        }

        return $filmsCollection;
    }
}
