<?php

declare(strict_types=1);

namespace App\Application\UseCase\User\Create;

use App\Application\Component\PasswordHash\PasswordHashGenerator;
use App\Domain\Entity\User;
use App\Domain\Repository\Flusher;
use App\Domain\Repository\Persister;
use App\Domain\Repository\UserRepositoryInterface;

final class CreateUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordHashGenerator $passwordHashGenerator,
        private readonly Persister $persister,
        private readonly Flusher $flusher,
    ) {
    }

    public function handle(CreateUserInput $input): User
    {
        $user = new User(
            $this->userRepository->nextId(),
            $input->getEmail(),
            $this->passwordHashGenerator->generate($input->getPassword()),
        );
        $this->persister->persist($user);
        $this->flusher->flush();

        return $user;
    }
}
