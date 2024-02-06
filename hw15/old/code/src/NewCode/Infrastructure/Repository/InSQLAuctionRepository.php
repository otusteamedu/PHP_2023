<?php

namespace old\code\src\NewCode\Infrastructure\Repository;

use old\code\src\NewCode\Domain\Model\Auction;
use old\code\src\NewCode\Domain\Repository\AuctionRepositoryInterface;

class InSQLAuctionRepository implements AuctionRepositoryInterface
{
    public function save(Auction $auction): void
    {
        return;
    }

    public function findById(int $id): ?Auction
    {
        return null;
    }
}
