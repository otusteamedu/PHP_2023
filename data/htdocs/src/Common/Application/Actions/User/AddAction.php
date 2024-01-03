<?php

namespace Common\Application\Actions\User;

use Common\Domain\User\User;
use Common\Infrastructure\User\UserDTO;
use Doctrine\ORM\EntityManagerInterface;

class AddAction
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(UserDTO $dto): User
    {
        // Создать админа
        $user = new User(
            $dto->getId(),
            $dto->getEmail(),
            $dto->getPhone(),
            password_hash($dto->getPassword(), PASSWORD_BCRYPT, ['cost' => 12]),
            $dto->getCity(),
            $dto->getUsername(),
            $dto->getFirstName(),
            $dto->getLastName()
        );

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
