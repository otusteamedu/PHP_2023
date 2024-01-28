<?php

declare(strict_types=1);

namespace Yevgen87\App\Services\Storage;

interface StorageInterface
{
    public function findAll();

    public function store(array $data);

    public function getById($id);

    public function update(int $id, array $data);

    public function delete(string $id);
}
