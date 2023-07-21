<?php

namespace Sva\BookShop\Domain;

class SearchQuery
{
    private string $query = "";

    public function __construct(string $query)
    {
        $query = $this->sanitize($query);
        $this->query = $query;
    }

    private function sanitize(string $query): string
    {
        $query = trim($query);
        $query = strip_tags($query);

        return $query;
    }

    public function get(): string
    {
        return $this->query;
    }
}
