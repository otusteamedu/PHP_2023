<?php

declare(strict_types=1);

namespace Application\Command\Search;

class BodyBuilder
{
    private string $index;
    private string $query;

    public function setQuery(string $query): void
    {
        $this->query = $query;
    }
    private string $lt;

    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    public function setLt(string $lt): void
    {
        $this->lt = $lt;
    }

    public function build(): array
    {
        return [
            'index' => $this->index,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'title' => [
                                        'query' => $this->query,
                                        'fuzziness' => 'auto'
                                    ]
                                ]
                            ]
                        ],
                        'filter' => [
                            [
                                'range' => [
                                    'price' => [
                                        'lt' => $this->lt
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
