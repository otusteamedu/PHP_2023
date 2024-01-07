<?php

namespace Radovinetch\Hw11\document;

use Radovinetch\Hw11\Storage;

abstract class Document
{
    protected array $tableHead = [];

    protected array $fills = [];

    /**
     * @param Storage $storage
     * @param array $params
     * @return Document[]
     */
    abstract public static function search(Storage $storage, array $params = []): array;

    public static function printHeadStatic(): void
    {
        $document = new static();
        $document->printHead();
    }

    public function printHead(): void
    {
        echo implode(' | ', array_keys($this->tableHead)) . PHP_EOL;
    }

    public function printDocument(): void
    {
        $fills = array_intersect_key(array_merge(array_flip($this->tableHead), $this->fills), array_flip($this->tableHead));
        echo implode(' | ', array_values($fills)) . PHP_EOL;
    }

    public function setFills(array $source): void
    {
        $this->fills = $source;
    }

    public function __get(string $name)
    {
        return $this->fills[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->fills[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->fills[$name]);
    }
}