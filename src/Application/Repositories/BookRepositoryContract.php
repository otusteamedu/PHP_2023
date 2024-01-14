<?php

declare(strict_types=1);

namespace src\Application\Repositories;

use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

interface BookRepositoryContract
{
    public function search(string $title, string $category, string $price): Elasticsearch|Promise;
}
