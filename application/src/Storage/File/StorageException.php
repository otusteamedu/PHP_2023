<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\File;

class StorageException extends \Exception
{
    private const CANNOT_OPEN_FILE = 1;

    public static function cannotOpenFile(string $pathToFile): self
    {
        return new self("Cannot open file: $pathToFile", self::CANNOT_OPEN_FILE);
    }
}
