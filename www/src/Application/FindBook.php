<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application;

use Yalanskiy\SearchApp\Application\Dto\FindBookRequest;
use Yalanskiy\SearchApp\Application\Dto\FindBookResponse;
use Yalanskiy\SearchApp\Domain\Repository\DataRepositoryInterface;

/**
 * FindBook
 */
class FindBook {
    public function __construct(
        private DataRepositoryInterface $provider
    )
    {
    
    }

    public function __invoke(FindBookRequest $request): FindBookResponse
    {
        return new FindBookResponse($this->provider->find($request->params));
    }
}