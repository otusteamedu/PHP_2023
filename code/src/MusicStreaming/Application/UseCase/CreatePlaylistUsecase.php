<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\UseCase;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Playlist;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\PlaylistMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\UserMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\TrackMapperInterface;

class CreatePlaylistUsecase
{
    protected PlaylistMapperInterface $playlistMapper;
    protected UserMapperInterface $userMapper;
    protected TrackMapperInterface $trackMapper;

    public function __construct(
        PlaylistMapperInterface $playlistMapper,
        UserMapperInterface $userMapper,
        TrackMapperInterface $trackMapper
    )
    {
        $this->playlistMapper = $playlistMapper;
        $this->userMapper = $userMapper;
        $this->trackMapper = $trackMapper;
    }



    public function create(array $playlistParams)
    {
        if (empty($playlistParams["name"])) {
            throw new \Exception("Incorrect request");
        }

        if (
            empty($playlistParams["tracksList"])
            || !is_array($playlistParams["tracksList"])    
        ) {
            throw new \Exception("Incorrect tracksList");
        }

        $playlistParams["userLogin"] = $_SESSION["userLogin"];
        $playlist = $this->createPaylistObject($playlistParams);

        $this->playlistMapper->insert(
            $playlist
        );
    }

    public function createPaylistObject($playlistParams): Playlist
    {
        $tracksList = [];
        foreach($playlistParams["tracksList"] as $trackId){
            $tracksList[] = $this->trackMapper->findById((int) $trackId);
        }

        return new Playlist(
            Playlist::FAKE_ID,
            $playlistParams["name"],
            $this->userMapper->findByLogin($playlistParams["userLogin"]),
            (array) $tracksList
        );
    }
}
