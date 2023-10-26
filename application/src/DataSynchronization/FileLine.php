<?php

declare(strict_types=1);

namespace Gesparo\ES\DataSynchronization;

class FileLine
{
    private array $data;

    /**
     * @throws DataSynchronizationException
     * @throws \JsonException
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->assertValidElasticSearchArray();
    }

    public function getValue(): array
    {
        return $this->data;
    }

    public function isCreate(): bool
    {
        return array_key_exists('create', $this->data);
    }

    /**
     * @throws DataSynchronizationException
     * @throws \JsonException
     */
    private function assertValidElasticSearchArray(): void
    {
        if (!$this->isCreate()) {
            $this->checkAsOrder();
            return;
        }

        $this->checkAsCreate();
    }

    /**
     * @throws DataSynchronizationException
     * @throws \JsonException
     */
    private function checkAsOrder(): void
    {
        $fields = [
            'title',
            'sku',
            'category',
            'price',
            'stock'
        ];

        foreach ($fields as $field) {
            if(!array_key_exists($field, $this->data)) {
                throw DataSynchronizationException::invalidElasticSearchOrder($field, $this->data);
            }
        }
    }

    /**
     * @throws DataSynchronizationException
     * @throws \JsonException
     */
    private function checkAsCreate(): void
    {
        $fields = [
            '_index',
            '_id'
        ];

        foreach ($fields as $field) {
            if(!array_key_exists($field, $this->data['create'])) {
                throw DataSynchronizationException::invalidElasticSearchCreate($field, $this->data['create']);
            }
        }
    }
}