<?php

namespace old\code\src\OldCode\Services;

use old\code\src\OldCode\Models\Auction;
use old\code\src\OldCode\Models\Member;
use old\code\src\OldCode\Models\Order;
use old\code\src\OldCode\Models\User;

class StartAuctionService
{
    protected User $user;
    protected int $orderId;
    protected array $auctionParams;

    public function __construct(array $params)
    {
        $this->user = $params['user'];
        $this->auctionParams = $params['auctionParams'];
        $this->orderId = $params['orderId'];
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $order = $this->getOrder();
        $this->checkValidation($order);
        $auction = $this->createAuction($order);
        $auction = $this->saveAuction($auction);
        $this->saveMembers($auction);
        $this->changeOrderStatusAfterSaveAuction($order);
    }

    /**
     * @throws \Exception
     */
    protected function getOrder(): Order
    {
        $order = Order::find($this->orderId);

        if (!$order) {
            throw new \Exception('Рейс не найден');
        }
        return $order;
    }

    /**
     * @throws \Exception
     */
    protected function checkValidation(Order $order): void
    {
        $this->checkOrderStatus($order);
    }

    /**
     * @throws \Exception
     */
    protected function checkOrderStatus(Order $order): void
    {
        if ($order->status !== Order::STATUS_CREATED) {
            throw new \Exception('Невозможно начать торги из данного статуса рейса');
        }
    }

    protected function saveMembers(Auction $auction): void
    {
        $members = $args['members'] ?? [];
        $data = [];
        foreach ($members as $member) {
            $data[] = [
                'auction_id' => $auction->id,
                'carrier_company_id' => $member['carrier_company_id'],
                'price' => $member['price'],

            ];
        }

        Member::insert($data);
    }

    protected function createAuction(Order $order): Auction
    {
        $auction = new Auction();
        $auction->title = $this->auctionParams['title'];
        $auction->step = $this->auctionParams['step'];

        return $auction;
    }

    protected function saveAuction(Auction $auction): Auction
    {
        $auction->save();
        return $auction;
    }

    protected function changeOrderStatusAfterSaveAuction(Order $order): void
    {
        $order->status = Order::STATUS_STARTED;
        $order->save();
    }
}

