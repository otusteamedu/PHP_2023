<?php

declare(strict_types=1);

namespace src;

class Test
{
    private \PDO $pdo;

    public function test()
    {
        $this->pdo = new \PDO();
    }
}
