<?php

declare(strict_types=1);

namespace App\Application\UseCase\User;

use App\Application\Component\PasswordHash\PasswordHashGenerator;
use App\Domain\Constant\UserRole;
use App\Domain\Entity\User;
use App\Domain\Repository\FlusherInterface;
use App\Domain\Repository\PersisterInterface;
use App\Domain\Repository\UserRepositoryInterface;

final class CreateUser
{
    public function __construct(
        private readonly PasswordHashGenerator $passwordHashGenerator,
        private readonly UserRepositoryInterface $userRepository,
        private readonly PersisterInterface $persister,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function handle(CreateUserInput $input): User
    {
        $user = new User(
            $this->userRepository->nextId(),
            $input->getEmail(),
            $this->passwordHashGenerator->generate($input->getPassword()),
            [UserRole::USER],
        );
        $this->persister->persist($user);
        $this->flusher->flush();

        return $user;
    }
}
