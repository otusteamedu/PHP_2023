<?php

namespace VLebedev\BookShop\Service;

interface ServiceInterface
{
    public function createIndex(array $params): void;

    public function uploadFileData(string $path): array;

    public function getById(array $params): array;

    public function search(array $params): array;
}
