<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Playlist;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\ConnectionManager;


use VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer\Response;
use VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer\EntityListResponse;
use VKorabelnikov\Hw16\MusicStreaming\Application\UseCase\CreatePlaylistUsecase;
use VKorabelnikov\Hw16\MusicStreaming\Application\UseCase\FindPlaylistUseCase;

use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Config\IniConfig;

use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\PlaylistMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\UserMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\TrackMapper;


class PlaylistController
{
    protected \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function create(array $requestParams): Response
    {
        $createPlaylistUsecase = new CreatePlaylistUsecase(
            new PlaylistMapper($this->pdo),
            new UserMapper($this->pdo),
            new TrackMapper($this->pdo)
        );
        $createPlaylistUsecase->create($requestParams);

        return new Response(true);
    }

    public function byuser(array $requestParams): EntityListResponse
    {
        $findPlaylistUseCase = new FindPlaylistUseCase(
            new PlaylistMapper($this->pdo),
            new UserMapper($this->pdo)
        );

        return new EntityListResponse(
            $findPlaylistUseCase->byuser($requestParams)
        );
    }
}
