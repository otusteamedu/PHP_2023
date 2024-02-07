<?php

namespace old\code\src\NewCode\Domain\Repository;

use old\code\src\NewCode\Domain\Model\Auction;

interface AuctionRepositoryInterface
{
    public function save(Auction $auction): void;
    public function findById(int $id): ?Auction;
}
