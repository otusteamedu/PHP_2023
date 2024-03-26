<?php
declare(strict_types=1);

namespace App\Consumer\CreateCarReport;

use App\DTO\OperationCarReportDTO;
use App\Service\OperationService;
use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

readonly class Consumer implements ConsumerInterface
{
    public function __construct(
        private SerializerInterface    $serializer,
        private EntityManagerInterface $em,
        private OperationService       $operationService,
    ) {
    }

    public function execute(AMQPMessage $msg): int
    {
        try {
            $operationCarReportDTO = $this->serializer->deserialize(
                $msg->getBody(),
                OperationCarReportDTO::class,
                'json'
            );
            $this->operationService->executeOperationCarReportDTO($operationCarReportDTO);
        } catch (Throwable $exception){
            return $this->reject($exception->getMessage());
        } finally {
            $this->em->clear();
            $this->em->getConnection()->close();
        }

        return static::MSG_ACK;
    }

    private function reject(string $error): int
    {
        echo "Incorrect message: $error";

        return self::MSG_REJECT;
    }
}
