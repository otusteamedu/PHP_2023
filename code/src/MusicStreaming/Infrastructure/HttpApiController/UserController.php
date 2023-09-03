<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController;

use VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer\Response;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\UserMapper;
use VKorabelnikov\Hw16\MusicStreaming\Application\UseCase\UserAuthUseCase;
use VKorabelnikov\Hw16\MusicStreaming\Application\UseCase\UserRegisterUseCase;

class UserController
{
    protected \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function auth(array $requestParams): Response
    {
        $createPlaylistUsecase = new UserAuthUseCase(new UserMapper($this->pdo));
        $createPlaylistUsecase->auth($requestParams);
        return new Response(true);
    }

    public function register(array $requestParams): Response
    {
        $createPlaylistUsecase = new UserRegisterUseCase(new UserMapper($this->pdo));
        $createPlaylistUsecase->register($requestParams);
        return new Response(true);
    }
}
