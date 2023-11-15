<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\File;

class DataCounter
{
    /**
     * @var resource $fileDescriptor
     */
    private $fileDescriptor;

    /**
     * @param resource $fileDescriptor
     */
    public function __construct($fileDescriptor)
    {
        $this->fileDescriptor = $fileDescriptor;
    }

    public function count(): int
    {
        // count lines in file
        $lineCount = 0;

        while (!feof($this->fileDescriptor)) {
            $line = fgets($this->fileDescriptor);

            if ($line === false) {
                break;
            }

            $lineCount++;
        }

        fseek($this->fileDescriptor, 0);

        return $lineCount;
    }
}
