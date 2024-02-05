<?php

namespace GKarman\CleanCode\NewCode\Domain\Repository;

use GKarman\CleanCode\NewCode\Domain\Model\Auction;

interface AuctionRepositoryInterface
{
    public function save(Auction $auction): void;
    public function findById(int $id): ?Auction;
}
