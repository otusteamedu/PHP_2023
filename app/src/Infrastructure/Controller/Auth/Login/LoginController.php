<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth\Login;

use App\Application\UseCase\User\AuthenticateUser;
use App\Application\UseCase\User\AuthenticateUserInput;
use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Exception\NotFoundException;
use App\Infrastructure\Security\AuthUser;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoginController extends AbstractController
{
    public function __construct(
        private readonly JWTTokenManagerInterface $jwtTokenManager,
        private readonly AuthenticateUser $authenticateUser,
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function handle(AuthenticateUserInput $input): JsonResponse
    {
        $user = $this->authenticateUser->handle($input);
        $token = $this->jwtTokenManager->createFromPayload(new AuthUser($user), []);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
