<?php

namespace old\code\src\NewCode\Application\UseCase;

use old\code\src\NewCode\Application\UseCase\Request\StartAuctionRequest;
use old\code\src\NewCode\Application\UseCase\Response\StartAuctionResponse;
use old\code\src\NewCode\Domain\Model\Auction;
use old\code\src\NewCode\Domain\Repository\AuctionRepositoryInterface;
use old\code\src\NewCode\Domain\ValueObject\Step;
use old\code\src\NewCode\Domain\ValueObject\Title;

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
