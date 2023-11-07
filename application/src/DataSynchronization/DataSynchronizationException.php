<?php

declare(strict_types=1);

namespace Gesparo\ES\DataSynchronization;

class DataSynchronizationException extends \Exception
{
    private const INVALID_ES_ORDER = 1;

    /**
     * @throws \JsonException
     */
    public static function invalidElasticSearchOrder(string $field, array $data): self
    {
        $encodedData = json_encode($data, JSON_THROW_ON_ERROR);
        return new self("Cannot find field '$field' in order with data '$encodedData'", self::INVALID_ES_ORDER);
    }

    /**
     * @throws \JsonException
     */
    public static function invalidElasticSearchCreate(string $field, array $data): self
    {
        $encodedData = json_encode($data, JSON_THROW_ON_ERROR);
        return new self("Cannot find field '$field' in create method with data '$encodedData'", self::INVALID_ES_ORDER);
    }
}
