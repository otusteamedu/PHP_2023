<?php

declare(strict_types=1);

namespace App\DataMapper;

use DatabaseAdapterInterface;
use PDO;

abstract class BaseDataMapper
{
    protected DatabaseAdapterInterface $database;

    public function __construct(DatabaseAdapterInterface $database)
    {
        $this->database = $database;
    }
}
