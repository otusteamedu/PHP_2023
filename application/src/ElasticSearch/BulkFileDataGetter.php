<?php

declare(strict_types=1);

namespace Gesparo\ES\ElasticSearch;

class BulkFileDataGetter
{
    /**
     * @var resource
     */
    private $fileResource;

    /**
     * @param resource $fileResource
     */
    public function __construct($fileResource)
    {
        $this->fileResource = $fileResource;
    }

    public function get(): \Generator
    {
        while (!feof($this->fileResource)) {
            yield fgets($this->fileResource);
        }
    }
}
