<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper;

use PDOStatement;

use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\TrackMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Exceptions\TableRowNotFoundException;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Track;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Genre;

class TrackMapper implements TrackMapperInterface
{
    /**
     * @var \PDO
     */
    private \PDO $pdo;

    private PDOStatement $selectbyIdStatement;
    private PDOStatement $selectByGenreStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectbyIdStatement = $this->pdo->prepare(
            "SELECT * FROM track WHERE id=:id"
        );

        $this->selectByGenreStatement = $this->pdo->prepare(
            "SELECT * FROM track WHERE genre_id=:genre_id LIMIT :limit OFFSET  :offset"
        );

        $this->insertStatement = $this->pdo->prepare(
            "INSERT INTO track (name, author, genre_id, duration, description, file_link, user_id) VALUES (:name, :author, :genre_id, :duration, :description, :file_link, :user_id)"
        );

        
        $this->updateStatement = $this->pdo->prepare(
            "UPDATE track SET name=:name WHERE id = :id"
        );

        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM track WHERE id = :id"
        );
        
    }


    /**
     * @param int $id
     *
     * @return Track
     */
    public function findById(int $id): Track
    {
        $this->selectbyIdStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectbyIdStatement->execute(["id" => $id]);
        $row = $this->selectbyIdStatement->fetch();

        if(!$row) {
            throw new TableRowNotFoundException("Track With Id Not Found");
        }

        $genreMapper = new GenreMapper($this->pdo);
        $userMapper = new UserMapper($this->pdo);

        return new Track(
            $id,
            $row['name'],
            $row['author'],
            $genreMapper->findById($row['genre_id']),
            $row['duration'],
            $row['description'],
            $row['file_link'],
            $userMapper->findById($row['user_id'])
        );
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function findByGenre(Genre $genre, $limit, $offset): array
    {
        $this->selectByGenreStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByGenreStatement->execute(
            [
                "genre_id" => $genre->getId(),
                "limit" => $limit,
                "offset" => $offset
            ]
        );

        $result = [];
        while($row = $this->selectByGenreStatement->fetch())
        {
            $genreMapper = new GenreMapper($this->pdo);
            $userMapper = new UserMapper($this->pdo);

            $result[] =  new Track(
                $row['id'],
                $row['name'],
                $row['author'],
                $genreMapper->findById($row['genre_id']),
                $row['duration'],
                $row['description'],
                $row['file_link'],
                $userMapper->findById($row['user_id'])
            );
        }

        return (array) $result;
    }

    public function insert(Track $track): void
    {
        $genreId = 0;
        if (is_numeric($track->getGenre()->getId())) {
            $genreId = $track->getGenre()->getId();
        } else {
            $genreMapper = new GenreMapper($this->pdo);
            $genreId = $genreMapper->insert($track->getGenre());
        }


        $userId = 0;
        if (is_numeric($track->getUser()->getId())) {
            $userId = $track->getUser()->getId();
        } else {
            $userMapper = new UserMapper($this->pdo);
            $userId = $userMapper->insert($track->getUser());
        }

        $this->insertStatement->execute(
            [
                "name" => $track->getName(),
                "author" => $track->getAuthor(),
                "genre_id" => $genreId,
                "duration" => $track->getDuration(),
                "description" => $track->getDescription(),
                "file_link" => $track->getFileLink(),
                "user_id" => $userId,
            ]
        );

        $track->setId(
            (int) $this->pdo->lastInsertId()
        );
    }

    public function update(Track $track): bool
    {
        return $this->updateStatement->execute([
            "id" => $track->getId(),
            "name" => $track->getName(),
            "author" => $track->getAuthor(),
            "genre_id" => $track->getGenre()->getId(),
            "duration" => $track->getDuration(),
            "description" => $track->getDescription(),
            "file_link" => $track->getFileLink(),
            "user_id" => $track->getUser()->getId(),
        ]);
    }

    /**
     * @param Track $track
     *
     * @return bool
     */
    public function delete(Track $track): bool
    {
        return $this->deleteStatement->execute(["id" => $track->getId()]);
    }
}