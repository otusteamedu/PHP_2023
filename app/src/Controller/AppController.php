<?php

declare(strict_types=1);

namespace Lebedev\App\Controller;

class AppController
{
    /**
     * Get query string params as array
     *
     * @return array
     */
    protected function getQueryParams(): array
    {
        parse_str($_SERVER['QUERY_STRING'], $query_params);
        return $query_params;
    }

    /**
     * Send API response
     *
     * @param $data
     * @param array $headers
     *
     * @return void
     */
    protected function response($data, array $headers = []): void
    {
        if (is_array($headers) && count($headers)) {
            foreach ($headers as $header) {
                header($header);
            }
        }
        echo $data;
    }
}
