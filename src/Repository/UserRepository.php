<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(private ContainerBagInterface $containerBag)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function findById(int $id): ?User
    {
        $telegramUserChatId = $this->containerBag->get('telegram_user_chat_id');

        return match ($id) {
            777 => new User(777, 'Везунчик', 'Андрей', 'Игоревич', $telegramUserChatId),
            1 => new User(1, 'Петренко', 'Олёна', 'Олеговна', $telegramUserChatId),
            2 => new User(1, 'Иванов', 'Алексей', 'Иванович', $telegramUserChatId),
            default => null,
        };
    }
}
