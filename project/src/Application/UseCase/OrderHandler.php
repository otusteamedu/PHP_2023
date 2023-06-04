<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Exception\AddEntityFailed;
use Vp\App\Application\Exception\FindEntityFailed;
use Vp\App\Application\UseCase\Contract\OrderHandlerInterface;
use Vp\App\Domain\Contract\DatabaseInterface;
use Vp\App\Domain\Model\Status;

class OrderHandler implements OrderHandlerInterface
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }
    public function handle(AMQPMessage $message): void
    {
        $orderId = $this->getOrderId($message);
        $orderModel = new \Vp\App\Domain\Model\Order($this->database);

        try {
            $orderCollection = $orderModel->find($orderId);
            /** @var \Vp\App\Domain\Model\Order $order */
            $order = $orderCollection->stream()->findFirst();
            $order->status_id = $this->getRandomStatusId();
            $order->save();
        } catch (FindEntityFailed | AddEntityFailed $e) {

        }
    }

    private function getOrderId(AMQPMessage $message): int
    {
        $messageParams = $this->getMessageParams($message);
        return $messageParams['id'];
    }

    private function getMessageParams(AMQPMessage $message): mixed
    {
        $messageParams = json_decode($message->getBody(), true);
        return $messageParams;
    }

    /**
     * @throws FindEntityFailed
     */
    private function getRandomStatusId(): ?int
    {
        $statusIds = [];
        $statusModel = new Status($this->database);
        $statusCollection = $statusModel->all();

        foreach ($statusCollection as $status) {
            $statusIds[] = $status->id;
        }

        $randKey = array_rand($statusIds);
        return $statusIds[$randKey];
    }
}
