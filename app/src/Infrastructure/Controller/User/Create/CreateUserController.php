<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User\Create;

use App\Application\Presenter\UserPresenter;
use App\Application\UseCase\User\CreateUser;
use App\Application\UseCase\User\CreateUserInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateUserController extends AbstractController
{
    public function __construct(
        private readonly CreateUser $createUser,
        private readonly UserPresenter $userPresenter,
    ) {
    }

    public function handle(CreateUserInput $input): JsonResponse
    {
        $user = $this->createUser->handle($input);

        return new JsonResponse(
            ['user' => $this->userPresenter->present($user)],
            201,
        );
    }
}
