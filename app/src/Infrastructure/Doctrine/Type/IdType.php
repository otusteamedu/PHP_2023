<?php

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObject\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class IdType extends Type
{
    public const ID = 'id';

    public function getName(): string
    {
        return self::ID;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'BIGINT';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        return new Id($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof Id) {
            return $value->getValue();
        }

        return null;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
