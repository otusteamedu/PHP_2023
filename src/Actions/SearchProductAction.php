<?php

namespace Sekaiichi\SuperApp\Actions;

use JsonException;

class SearchProductAction
{
    /**
     * @throws JsonException
     */
    public function __invoke($searchTerm): array
    {
        $ch = curl_init("https://dummyjson.com/products/search?q=$searchTerm");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }
}
