<?php

namespace Klobkovsky\App\Model\Interface;

interface ElasticEntityInterface
{
    public function getIndexName(): string;
    public function getDataFile(): string;
    public function getIndexParam(): array;
    public function getSearchParam(array $paramValues):array;
}
