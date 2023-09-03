<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Playlist;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\User;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\PlaylistMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Exceptions\TableRowNotFoundException;
use PDOStatement;

class PlaylistMapper implements PlaylistMapperInterface
{
    /**
     * @var \PDO
     */
    private \PDO $pdo;

    private PDOStatement $selectByIdStatement;
    private PDOStatement $selectByNameStatement;
    private PDOStatement $selectByUserStatement;
    private PDOStatement $selectPlaylistTracksTableStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $insertPlaylistTrackStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $deleteAllPlaylistTracksStatement;
    private PDOStatement $deleteSinglePlaylistTrackStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectByIdStatement = $this->pdo->prepare(
            "SELECT * FROM playlist WHERE id=:id"
        );

        $this->selectByNameStatement = $this->pdo->prepare(
            "SELECT * FROM playlist WHERE name=:name"
        );

        $this->selectByUserStatement = $this->pdo->prepare(
            "SELECT * FROM playlist WHERE user_id=:user_id"
        );

        $this->selectPlaylistTracksTableStatement = $this->pdo->prepare(
            "SELECT * FROM playlists_tracks WHERE playlist_id=:playlist_id"
        );

        $this->insertStatement = $this->pdo->prepare(
            "INSERT INTO playlist (name, user_id) VALUES (:name, :user_id)"
        );

        $this->insertPlaylistTrackStatement = $this->pdo->prepare(
            "INSERT INTO playlists_tracks (playlist_id, track_id) VALUES (:playlist_id, :track_id)"
        );

        $this->updateStatement = $this->pdo->prepare(
            "UPDATE playlist SET name=:name WHERE id = :id"
        );

        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM playlist WHERE id = :id"
        );

        $this->deleteAllPlaylistTracksStatement = $this->pdo->prepare(
            "DELETE FROM playlists_tracks WHERE playlist_id = :playlist_id"
        );

        $this->deleteSinglePlaylistTrackStatement = $this->pdo->prepare(
            "DELETE FROM playlists_tracks WHERE playlist_id = :playlist_id AND track_id = :track_id"
        );
    }


    /**
     * @param int $id
     *
     * @return Playlist
     */
    public function findById(int $id): Playlist
    {
        $this->selectByIdStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByIdStatement->execute(["id" => $id]);
        $row = $this->selectByIdStatement->fetch();

        if (!$row) {
            throw new TableRowNotFoundException("Playlist With Id Not Found");
        }

        $userMapper = new UserMapper($this->pdo);
        return new Playlist(
            $row['id'],
            $row['name'],
            $userMapper->findById($row['user_id']),
            $this->loadPlaylistTracksList($row['id'])
        );
    }

    public function findByName(string $name): Playlist
    {
        $this->selectByNameStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByNameStatement->execute(["name" => $name]);
        $row = $this->selectByNameStatement->fetch();

        if (!$row) {
            throw new TableRowNotFoundException("Playlist With name Not Found");
        }

        $userMapper = new UserMapper($this->pdo);
        return new Playlist(
            $row['id'],
            $row['name'],
            $userMapper->findById($row['user_id']),
            $this->loadPlaylistTracksList($row['id'])
        );
    }

    public function findByUser(User $user): array
    {
        $this->selectByUserStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByUserStatement->execute(["user_id" => $user->getId()]);

        $result = [];
        while ($row = $this->selectByUserStatement->fetch())
        {
            $userMapper = new UserMapper($this->pdo);
            $result[] = new Playlist(
                $row['id'],
                $row['name'],
                $userMapper->findById($row['user_id']),
                $this->loadPlaylistTracksList($row['id'])
            );
        }

        return $result;
    }

    private function loadPlaylistTracksList(int $playlistId): array
    {
        $tracksList = [];
        $this->selectPlaylistTracksTableStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectPlaylistTracksTableStatement->execute(["playlist_id" => $playlistId]);

        while ($row = $this->selectPlaylistTracksTableStatement->fetch()) {
            $trackMapper = new TrackMapper($this->pdo);
            $tracksList[] = $trackMapper->findById($row["track_id"]);
        }

        return $tracksList;
    }

    public function insert(Playlist $playlist): void
    {
        $this->insertStatement->execute(
            [
                "name" => $playlist->getName(),
                "user_id" => $playlist->getUser()->getId()
            ]
        );

        $playlist->setId(
            (int) $this->pdo->lastInsertId()
        );

        $playlistTracks = $playlist->getTracksList();
        foreach ($playlistTracks as $track) {
            $this->insertPlaylistTrackStatement->execute(
                [
                    "playlist_id" => $playlist->getId(),
                    "track_id" => $track->getId()
                ]
            );
        }
    }

    public function update(Playlist $playlist): bool
    {
        $success = $this->updateStatement->execute([
            "id" => $playlist->getId(),
            "name" => $playlist->getName()
        ]);

        $dbTracksList = $this->loadPlaylistTracksList($playlist->getId());
        $tracksToInsert = [];
        $tracksToDelete = [];

        foreach ($playlist->getTracksList() as $inputTrack) {
            if ($inputTrack->getId() < 0) {
                $tracksToInsert[] = $inputTrack;
            }
        }
        
        foreach ($playlist->getTracksList() as $inputTrack) {
            $trackAttachedToPlaylist = false;
            foreach ($dbTracksList as $dbTrack) {
                if ($inputTrack->getId() == $dbTrack->getId()) {
                    $trackAttachedToPlaylist = true;
                    break;
                }
            }
            if(!$trackAttachedToPlaylist) {
                $tracksToInsert[] = $inputTrack;
            }
        }


        foreach ($dbTracksList as $dbTrack) {
            $deletedFromPlaylist = true;
            foreach ($playlist->getTracksList() as $inputTrack) {
                if ($inputTrack->getId() == $dbTrack->getId()) {
                    $deletedFromPlaylist = false;
                    break;
                }
            }
            if(!$deletedFromPlaylist) {
                $tracksToDelete[] = $inputTrack;
            }
        }

        foreach ($tracksToInsert as $track) {
            $successInsert = $this->insertPlaylistTrackStatement->execute(
                [
                    "playlist_id" => $playlist->getId(),
                    "track_id" => $track->getId()
                ]
            );

            if (!$successInsert) {
                $success = false;
            }
        }

        foreach ($tracksToDelete as $track) {
            $successDelete = $this->deleteSinglePlaylistTrackStatement->execute(
                [
                    "playlist_id" => $playlist->getId(),
                    "track_id" => $track->getId()
                ]
            );

            if (!$successDelete) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * @param Playlist $playlist
     *
     * @return bool
     */
    public function delete(Playlist $playlist): bool
    {
        $successDeletePlaylist = $this->deleteStatement->execute(["id" => $playlist->getId()]);
        $successDeleteTracksCorrespondence = $this->deleteAllPlaylistTracksStatement->execute(["playlist_id" => $playlist->getId()]);

        return $successDeletePlaylist && $successDeleteTracksCorrespondence;
    }
}
