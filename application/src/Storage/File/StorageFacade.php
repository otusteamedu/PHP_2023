<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\File;

use Gesparo\HW\Storage\StoreInterface;
use Gesparo\HW\Storage\ValueObject\StoreElement;

class StorageFacade implements StoreInterface
{
    private const DATA_FILE_NAME = 'data.txt';
    /**
     * @var resource
     */
    private $fileDescriptor;

    /**
     * @throws StorageException
     */
    public function __construct(string $pathToFolder)
    {
        $pathToFile = $pathToFolder . self::DATA_FILE_NAME;
        $fileDescriptor = fopen($pathToFile, 'ab+');

        if ($fileDescriptor === false) {
            throw StorageException::cannotOpenFile($pathToFile);
        }

        $this->fileDescriptor = $fileDescriptor;
    }

    /**
     * @return StoreElement[]
     */
    public function getAll(): array
    {
        return (new DataGetter($this->fileDescriptor))->get();
    }

    public function save(string $phone, string $message): void
    {
        fwrite($this->fileDescriptor, sprintf("%s;%s\n", $phone, $message));

        fseek($this->fileDescriptor, 0);
    }

    public function count(): int
    {
        return (new DataCounter($this->fileDescriptor))->count();
    }

    public function clear(): void
    {
        ftruncate($this->fileDescriptor, 0);
    }
}
