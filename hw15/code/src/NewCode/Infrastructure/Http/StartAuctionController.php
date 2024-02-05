<?php

namespace GKarman\CleanCode\NewCode\Infrastructure\Http;

use GKarman\CleanCode\NewCode\Application\UseCase\Request\StartAuctionRequest;
use GKarman\CleanCode\NewCode\Application\UseCase\StartAuctionUseCase;
use http\Client\Response;

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
