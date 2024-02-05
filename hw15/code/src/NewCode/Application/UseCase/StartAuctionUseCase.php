<?php

namespace GKarman\CleanCode\NewCode\Application\UseCase;

use GKarman\CleanCode\NewCode\Application\UseCase\Request\StartAuctionRequest;
use GKarman\CleanCode\NewCode\Application\UseCase\Response\StartAuctionResponse;
use GKarman\CleanCode\NewCode\Domain\Model\Auction;
use GKarman\CleanCode\NewCode\Domain\Repository\AuctionRepositoryInterface;
use GKarman\CleanCode\NewCode\Domain\ValueObject\Step;
use GKarman\CleanCode\NewCode\Domain\ValueObject\Title;

class StartAuctionUseCase
{
    public function __construct(
        private AuctionRepositoryInterface $auctionRepository
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(StartAuctionRequest $request): StartAuctionResponse
    {
        $auction = new Auction(
            new Title($request->title),
            new Step($request->step),
        );

        $this->auctionRepository->save($auction);
    }
}
