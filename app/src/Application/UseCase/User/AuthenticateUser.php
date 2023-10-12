<?php

declare(strict_types=1);

namespace App\Application\UseCase\User;

use App\Application\Component\PasswordHash\PasswordHashValidator;
use App\Domain\Entity\User;
use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\UserRepositoryInterface;

final class AuthenticateUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordHashValidator $passwordHashValidator,
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function handle(AuthenticateUserInput $input): User
    {
        $user = $this->userRepository->firstByEmail($input->getEmail());

        if (null === $user) {
            throw new NotFoundException('User not found.');
        }

        if (!$this->passwordHashValidator->validate($input->getPassword(), $user->getPasswordHash())) {
            throw new InvalidArgumentException('Wrong password.');
        }

        return $user;
    }
}
