<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\UseCase;

use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\UserMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\User;

class UserRegisterUseCase
{
    protected UserMapperInterface $userMapper;

    public function __construct(
        UserMapperInterface $userMapper
    ) {
        $this->userMapper = $userMapper;
    }

    public function register(array $userParams): void
    {
        $user = new User(
            User::FAKE_ID,
            $userParams["login"],
            sha1($userParams["password"])
        );
        $this->userMapper->insert($user);
    }
}
