<?php

declare(strict_types=1);

namespace Yevgen87\App\Models;

interface ActiveRecordInterface
{
    public function fetchAll();

    public function fetchById(int $id);

    public function insert(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
