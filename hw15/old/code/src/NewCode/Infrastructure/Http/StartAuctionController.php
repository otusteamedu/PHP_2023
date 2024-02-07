<?php

namespace old\code\src\NewCode\Infrastructure\Http;

use http\Client\Response;
use old\code\src\NewCode\Application\UseCase\Request\StartAuctionRequest;
use old\code\src\NewCode\Application\UseCase\StartAuctionUseCase;

class StartAuctionController
{
    public function __construct(
        private StartAuctionUseCase $auctionUseCase,
    )
    {
    }

    public function __invoke(StartAuctionRequest $request): Response
    {
        try {
            $response = ($this->auctionUseCase)($request);
        } catch (\Throwable $e) {

        }

        return $response;
    }
}
