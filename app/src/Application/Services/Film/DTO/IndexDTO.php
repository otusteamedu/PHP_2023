<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\Services\Film\DTO;

class IndexDTO
{
    public int $limit;

    public int $offset;

    public string $order_by;

    public string $order_direction;

    public function __construct(
        $limit,
        $offset,
        $order_by,
        $order_direction
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order_by = $order_by;
        $this->order_direction = strtolower($order_direction) ?? 'desc' ? 'desc' : 'asc';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) ($data['limit'] ?? 10),
            (int) ($data['offset'] ?? 0),
            $data['order_by'] ?? 'id',
            strtolower($data['order_direction'] ?? 'desc') == 'desc' ? 'desc' : 'asc'
        );
    }
}
