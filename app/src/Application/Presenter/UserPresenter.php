<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Application\ViewModel\UserViewModel;
use App\Domain\Entity\User;

final class UserPresenter
{
    public function __construct(
        private readonly IdPresenter $idPresenter,
        private readonly EmailPresenter $emailPresenter,
    ) {
    }

    public function present(User $user): UserViewModel
    {
        return new UserViewModel(
            $this->idPresenter->present($user->getId()),
            $this->emailPresenter->present($user->getEmail()),
            $user->getRoles(),
        );
    }
}
