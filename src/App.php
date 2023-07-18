<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Database\UserMapper;

final readonly class App
{
    public function __construct(
        private UserMapper $userMapper,
    ) {
    }

    public function run(): void
    {
        // Create User and add them into IdentityMap
        $user = $this->userMapper->insert(['name' => 'Linus', 'surname' => 'Sinus']);

        // Get User from IdentityMap
        $this->userMapper->findById($user->getId());

        // Get User from db
        $this->userMapper->refresh()->findById($user->getId());
    }
}
