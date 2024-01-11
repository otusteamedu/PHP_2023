<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\Factory\TransactionFactory;
use Gesparo\Homework\Domain\ValueObject\ConsumerBankStatementRequest;
use Gesparo\Homework\Domain\ValueObject\Transaction;

class StatementManager
{
    public function __construct(
        private readonly TransactionFactory $transactionFactory
    )
    {
    }

    /**
     * @throws AppException
     * @throws \Exception
     */
    public function manage(ConsumerBankStatementRequest $request): array
    {
        sleep(15);

        if ($this->isUnsuccessful()) {
            throw AppException::statementRequestWasNotSuccessful($request->getMessageId());
        }

        $result = [];

        for($i = 0; $i < random_int(1, 10); $i++) {
            $result[] = $this->transactionFactory->create(
                $request->getAccountNumber(),
                (string) random_int(100, 1000),
                Transaction::CURRENCY_EUR,
                $this->getRandomDate(),
                'Dummy transaction ' . $i
            );
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    private function isUnsuccessful(): bool
    {
        return random_int(0, 100) > 50;
    }

    /**
     * @throws \Exception
     */
    private function getRandomDate(): \DateTime
    {
        $randomTimestamp = random_int(strtotime('-1 year'), time());

        return new \DateTime(date('Y-m-d H:i:s', $randomTimestamp));
    }
}
