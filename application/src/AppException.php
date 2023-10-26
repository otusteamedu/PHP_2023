<?php

declare(strict_types=1);

namespace Gesparo\ES;

class AppException extends \Exception
{
    private const ELASTIC_BULK_FILE_NOT_FOUND = 1;
    private const ELASTIC_BULK_FILE_IS_NOT_READABLE = 2;
    private const ELASTIC_BULK_CANNOT_OPEN_FILE = 3;
    private const PRICE_CANNOT_BE_LESS_THAN_ZERO = 4;
    private const TITLE_CANNOT_BE_EMPTY = 5;

    public static function cannotFindElasticBulkFile(string $path): self
    {
        return new self(sprintf('Elastic bulk file not found in path: %s', $path), self::ELASTIC_BULK_FILE_NOT_FOUND);
    }

    public static function cannotReadBulkFile(string $path): self
    {
        return new self(sprintf('Elastic bulk file is not readable in path: %s', $path), self::ELASTIC_BULK_FILE_IS_NOT_READABLE);
    }

    public static function cannotOpenBulkFile(string $path): self
    {
        return new self(sprintf('Cannot open elastic bulk file in path: %s', $path), self::ELASTIC_BULK_CANNOT_OPEN_FILE);
    }

    public static function priceCannotBeLessThanZero(int $price): self
    {
        return new self(sprintf("Price '%d' cannot be less than zero", $price), self::PRICE_CANNOT_BE_LESS_THAN_ZERO);
    }

    public static function titleCannotBeEmpty(): self
    {
        return new self("Title cannot be empty", self::TITLE_CANNOT_BE_EMPTY);
    }
}
