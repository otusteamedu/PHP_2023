<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\File;

use Gesparo\HW\Storage\ValueObject\StoreElement;

class DataGetter
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

    public function get(): array
    {
        $result = [];

        while (!feof($this->fileDescriptor)) {
            $line = fgets($this->fileDescriptor);

            if ($line === false) {
                break;
            }

            $result[] = new StoreElement(...explode(';', $line));
        }

        fseek($this->fileDescriptor, 0);

        return $result;
    }
}
