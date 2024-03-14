<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Application\UseCase;

use AYamaliev\hw11\Application\Dto\SearchDto;
use AYamaliev\hw11\Application\OutputResult;
use AYamaliev\hw11\Domain\Repository\BookRepositoryInterface;

class SearchBooks
{
    public function __construct(private BookRepositoryInterface $client)
    {
    }

    public function __invoke(SearchDto $searchDto)
    {
        $response = $this->client->search($searchDto);
        ((new OutputResult())($response));
    }
}
