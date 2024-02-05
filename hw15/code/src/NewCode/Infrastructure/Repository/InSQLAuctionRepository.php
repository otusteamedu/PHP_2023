<?php

namespace GKarman\CleanCode\NewCode\Infrastructure\Repository;

use GKarman\CleanCode\NewCode\Domain\Model\Auction;
use GKarman\CleanCode\NewCode\Domain\Repository\AuctionRepositoryInterface;

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
