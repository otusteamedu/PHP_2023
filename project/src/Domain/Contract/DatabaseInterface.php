<?php

declare(strict_types=1);

namespace Vp\App\Domain\Contract;

use PDO;

interface DatabaseInterface
{
    public function getConnection(): PDO;
}
