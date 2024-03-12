<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\OrderBankStatementDTO;
use App\Event\SendNotifyTelegram;
use App\Exception\UserNotFoundException;
use App\Exception\ValidationException;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class BankStatementService
{
    public function __construct(
        private AsyncService             $asyncService,
        private UserRepositoryInterface  $userRepository,
        private EventDispatcherInterface $eventDispatcher,
        private ValidatorInterface       $validator,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function orderBankStatementAsync(OrderBankStatementDTO $orderBankStatementDTO): void
    {
        $errors = $this->validator->validate($orderBankStatementDTO);

        if ($errors->count() > 0) {
            throw new ValidationException($errors);
        }

        $this->asyncService->publishToExchange(AsyncService::ORDER_BANK_STATEMENT, json_encode($orderBankStatementDTO));
    }

    /**
     * @throws UserNotFoundException
     */
    public function createBankStatement(OrderBankStatementDTO $orderBankStatementDTO): void
    {
        $user = $this->userRepository->findById($orderBankStatementDTO->userId);

        if (!$user) {
            throw new UserNotFoundException(sprintf('Пользователь с id=%s не найден', $orderBankStatementDTO->userId));
        }

        $typeReport = match ($orderBankStatementDTO->type) {
            1 => 'Дебетовые карты',
            2 => 'Кредитные карты',
            default => 'Для всех карт',
        };

        $bankStatement = sprintf(
            "Банковская выписка за период %s-%s\nДля пользователя: %s %s %s\n%s\n\n ...\n",
            $orderBankStatementDTO->startDate->format('Y-m-d H:i:s'),
            $orderBankStatementDTO->endDate->format('Y-m-d H:i:s'),
            $user->getSurname(),
            $user->getName(),
            $user->getPatronymic(),
            $typeReport,
        );

        $this->eventDispatcher->dispatch(new SendNotifyTelegram($user, $bankStatement));
    }
}
