<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\DataBase\Contract;

use PDO;

interface DatabaseInterface
{
    public function getConnection(): PDO;
}
