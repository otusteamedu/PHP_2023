<?php

namespace src\extern\inputFromDB\sqlite3;

interface DBAdapterInterface
{
    public static function build(): self;

    public function setSource(string $source);

    public function setQuery(string $query);

    public function fetch();

    public function getData(): array;
}
