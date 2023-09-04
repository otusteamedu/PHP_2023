<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController;

use VKorabelnikov\Hw16\MusicStreaming\Application\UseCase\UploadTrackUseCase;
use VKorabelnikov\Hw16\MusicStreaming\Application\UseCase\FindTrackUseCase;
use VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer\EntityListResponse;
use VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer\Response;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\GenreMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\UserMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\TrackMapper;

class TrackController
{
    protected \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function upload(array $requestParams): Response
    {
        $uploadTrackUseCase = new UploadTrackUseCase(
            new GenreMapper($this->pdo),
            new UserMapper($this->pdo),
            new TrackMapper($this->pdo)
        );
        $uploadTrackUseCase->upload($requestParams);

        return new Response(true);
    }

    public function bygenre(array $requestParams): EntityListResponse
    {
        $findTrackUseCase = new FindTrackUseCase(
            new GenreMapper($this->pdo),
            new UserMapper($this->pdo),
            new TrackMapper($this->pdo)
        );

        return new EntityListResponse(
            $findTrackUseCase->bygenre($requestParams)
        );
    }
}
