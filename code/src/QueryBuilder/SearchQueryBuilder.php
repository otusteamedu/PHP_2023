<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic\QueryBuilder;

abstract class SearchQueryBuilder
{
    protected const MORE_THAN = 'gt';

    protected const LESS_THAN = 'lt';

    protected array $params = [];

    public function getParams(): array
    {
        return $this->params;
    }

    protected function setMust(string $name, string $value): void
    {
        $this->params['bool']['must'][]['match'][$name] = [
            'query' => $value,
            'fuzziness' => 'auto'
        ];
    }

    protected function setRange(string $name, int|string $value, string $sign): void
    {
        $this->params['bool']['filter'][]['range'][$name][$sign] = $value;
    }
}
