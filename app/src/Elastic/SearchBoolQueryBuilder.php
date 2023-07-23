<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\Elastic;

class SearchBoolQueryBuilder
{
    private array $queryBody;

    public function __construct(string $index)
    {
        $this->queryBody = [
            'index' => $index,
            'body' => [
                'query' => [
                    'bool' => [],
                ],
            ],
        ];
    }

    public function match(string $field, string | null $value, string $rule = 'should'): self
    {
        if (!$value) {
            return $this;
        }

        $this->queryBody['body']['query']['bool'][$rule][]['match'][$field] = $value ?? "";
        return $this;
    }

    public function term(string $field, string | null $value, string $rule = 'should'): self
    {
        if (!$value) {
            return $this;
        }

        $this->queryBody['body']['query']['bool'][$rule][]['term'][$field] =  $value ?? "";
        return $this;
    }

    public function range(string $field, array $range, string $rule = 'must'): self
    {
        if (!$range) {
            return $this;
        }

        $this->queryBody['body']['query']['bool'][$rule][]['range'][$field] = $range;
        return $this;
    }

    public function build(): array
    {
        return $this->queryBody;
    }
}
