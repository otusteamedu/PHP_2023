<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\UseCase;

use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\PlaylistMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\UserMapperInterface;

class FindPlaylistUseCase
{
    protected PlaylistMapperInterface $playlistMapper;
    protected UserMapperInterface $userMapper;

    public function __construct(
        PlaylistMapperInterface $playlistMapper,
        UserMapperInterface $userMapper
    ) {
        $this->playlistMapper = $playlistMapper;
        $this->userMapper = $userMapper;
    }

    public function byuser(array $requestParams): array
    {
        $user = $this->userMapper->findByLogin($requestParams["userLogin"]);
        return $this->playlistMapper->findByUser($user);
    }
}
