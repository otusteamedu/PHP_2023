<?php

namespace App;

class SelectQueryBuilder
{
    private ?string $from;
    private ?string $where;
    private ?string $orderBy;
    private array $params = [];

    public function from(string $table): SelectQueryBuilder
    {
        $this->from = "SELECT * FROM {$table}";
        return $this;
    }

    public function where(string $field, string $value): SelectQueryBuilder
    {
        if (is_null($this->where)) {
            $this->where = "WHERE {$field} = ?";
        } else {
            $this->where .= " AND {$field} = ?";
        }

        $this->params[] = $value;

        return $this;
    }

    public function orderBy(string $field, string $direction): SelectQueryBuilder
    {
        $this->orderBy = "ORDER BY {$field} {$direction}";
        return $this;
    }

    public function execute(): DatabaseQueryResult
    {
        $query = "{$this->from} {$this->where} {$this->orderBy}";
        return new DatabaseQueryResult($query, $this->params);
    }
}
