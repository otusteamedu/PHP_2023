<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Silex\Application;
use Vp\App\Application\Dto\Data\OrderData;
use Vp\App\Application\Dto\Output\ResultAdd;
use Vp\App\Application\Dto\Output\ResultOrderStatus;
use Vp\App\Application\Exception\AddEntityFailed;
use Vp\App\Application\Exception\FindEntityFailed;
use Vp\App\Application\Message;
use Vp\App\Application\OrderStatus;

class Order
{
    private Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function create(OrderData $orderData): ResultAdd
    {
        try {
            $order = $this->app['models.order'];
            $order->product_id = $orderData->getProductId();
            $order->quantity = $orderData->getQuantity();
            $order->status_id = $this->getStatusIdByCode(OrderStatus::created->name);
            $order->save();
            return new ResultAdd(true, null, $order->id);
        } catch (AddEntityFailed $e) {
            return new ResultAdd(false, Message::FAILED_ADD_ENTITY . ': ' . $e->getMessage());
        }
    }

    private function getStatusIdByCode(string $statusCode): ?int
    {
        $model = $this->app['models.status'];
        try {
            $statusCollection = $model->where('code', $statusCode);
            $status = $statusCollection->stream()->findFirst();
            return $status->id;
        } catch (FindEntityFailed $e) {
            return null;
        }
    }

    public function getStatus(int $orderId): ResultOrderStatus
    {
        try {
            $model = $this->app['models.order'];
            $order = $model->findOne($orderId);
            $status = $order->status;
            return new ResultOrderStatus(true, $status->name);
        } catch (FindEntityFailed $e) {
            return new ResultOrderStatus(false, null, $e->getMessage());
        }
    }
}
