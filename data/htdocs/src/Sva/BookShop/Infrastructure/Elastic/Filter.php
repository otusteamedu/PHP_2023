<?php

namespace Sva\BookShop\Infrastructure\Elastic;

class Filter
{
    private array $filter = [];

    public function __construct()
    {
    }

    public function addRange($field, $type, $value, $nestedPath = null): void
    {
        if ($nestedPath) {
            $item['nested']['path'] = $field;
            $item['nested']['query']['bool']['filter'] = [
                'range' => [
                    $nestedPath => [
                        $type => $value
                    ]
                ]
            ];
        } else {
            $item = [
                'range' => [
                    $field => [
                        $type => $value
                    ]
                ]
            ];
        }
        $this->filter['query']['bool']['filter'][] = $item;
    }

    public function addTerm($field, $value): void
    {
        $this->filter['query']['bool']['filter'][] = [
            'term' => [
                $field => $value
            ]
        ];
    }

    public function addMatch($field, $value): void
    {
        $this->filter['query']['bool']['must'][] = [
            'match' => [
                $field => [
                    "query" => $value,
                    "fuzziness" => "auto"
                ]
            ]
        ];
    }

//    public function addNested(string $fieldsName) : void
//    {
//        $this->nestedFields[] = $fieldsName;
//    }

    public function get(): array
    {
        return $this->filter;
    }
}
