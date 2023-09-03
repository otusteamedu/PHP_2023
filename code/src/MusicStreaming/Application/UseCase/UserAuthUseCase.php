<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\UseCase;

use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\UserMapperInterface;

class UserAuthUseCase
{
    protected UserMapperInterface $userMapper;

    public function __construct(
        UserMapperInterface $userMapper
    )
    {
        $this->userMapper = $userMapper;
    }

    public function auth(array $UserParams): void
    {
        $user = $this->userMapper->findByLogin($UserParams["login"]);
        if ($user->getPasswordSha1() !== sha1($UserParams["password"])) {
            throw new \Exception("Login or password is wrong!");
        } else {
            $_SESSION["userLogin"] = $user->getLogin();
        }
    }
}
