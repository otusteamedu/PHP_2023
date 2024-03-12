<?php
declare(strict_types=1);

namespace App\Consumer\OrderBankStatement;

use App\Consumer\OrderBankStatement\Input\Message;
use App\DTO\OrderBankStatementDTO;
use App\Service\BankStatementService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

readonly class Consumer implements ConsumerInterface
{
    public function __construct(
        private ValidatorInterface   $validator,
        private BankStatementService $bankStatementService,
    ) {
    }

    public function execute(AMQPMessage $msg): int
    {
        try {
            echo $msg->getBody() . "\n";

            $message = Message::createFromQueue($msg->getBody());
            $errors  = $this->validator->validate($message);

            if ($errors->count() > 0) {
                return $this->reject((string)$errors);
            }

            $orderBankStatementDTO = new OrderBankStatementDTO(
                $message->getStartDate(),
                $message->getEndDate(),
                $message->getType(),
                $message->getUserId(),
            );
            $this->bankStatementService->createBankStatement($orderBankStatementDTO);
        } catch (Throwable $exception) {
            return $this->reject($exception->getMessage());
        }

        return static::MSG_ACK;
    }

    private function reject(string $error): int
    {
        echo "Incorrect message: $error";

        return static::MSG_REJECT;
    }
}
