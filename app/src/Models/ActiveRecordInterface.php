<?php

declare(strict_types=1);

namespace Yevgen87\App\Models;

interface ActiveRecordInterface
{
    function fetchAll();

    function fetchById(int $id);

    function insert(array $data);

    function update(int $id, array $data);

    function delete(int $id);
}
