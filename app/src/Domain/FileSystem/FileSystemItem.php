<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem;

abstract class FileSystemItem implements FileSystemItemInterface
{
    /**
     * @var string
     */
    public string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function render(): string
    {
        return sprintf("|--%s (%sb)\n", basename($this->filePath), $this->getSize());
    }

    abstract public function getSize(): int;
}
