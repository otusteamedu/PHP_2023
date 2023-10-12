<?php

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObject\NotEmptyString;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class NotEmptyStringType extends Type
{
    public const NOT_EMPTY_STRING = 'not_empty_string';

    public function getName(): string
    {
        return self::NOT_EMPTY_STRING;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if (isset($column['length'])) {
            return sprintf('VARCHAR(%d)', $column['length']);
        }

        return 'VARCHAR';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        return new NotEmptyString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof NotEmptyString) {
            return $value->getValue();
        }

        return $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
