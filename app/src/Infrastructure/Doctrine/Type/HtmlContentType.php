<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObject\HtmlContent;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class HtmlContentType extends Type
{
    public const HTML_CONTENT_TYPE = 'html_content';

    public function getName(): string
    {
        return self::HTML_CONTENT_TYPE;
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

        return new HtmlContent($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof HtmlContent) {
            return $value->getValue();
        }

        return $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
