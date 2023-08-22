<?php

declare(strict_types=1);

namespace App\News\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,

        #[Assert\NotBlank]
        public string $email,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
