<?php

declare(strict_types=1);

namespace Gesparo\ES\Service;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\ElasticSearch\Searcher;
use Gesparo\ES\OutputHelper;
use Gesparo\ES\Search\Price;
use Gesparo\ES\Search\ResultOutputManager;
use Gesparo\ES\Search\Title;

class SearchService
{
    private Searcher $searcher;
    private Price $price;
    private Title $title;
    private OutputHelper $outputHelper;

    public function __construct(Searcher $searcher, Price $price, Title $title, OutputHelper $outputHelper)
    {
        $this->price = $price;
        $this->title = $title;
        $this->searcher = $searcher;
        $this->outputHelper = $outputHelper;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function makeSearch(): void
    {
        $response = $this->searcher->search($this->price, $this->title);

        (new ResultOutputManager($this->outputHelper))->makeOutput($response);
    }
}
