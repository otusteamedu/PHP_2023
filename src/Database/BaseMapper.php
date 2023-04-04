<?php

declare(strict_types=1);

namespace Twent\Hw13\Database;

use PDO;
use PDOStatement;

abstract class BaseMapper
{
    public function __construct(
        protected ?PDO $connection,
        protected ?IdentityMap $map = new IdentityMap()
    ) {
    }
}
