<?php
declare(strict_types=1);

namespace Art\Code\Infrastructure\Interface;

interface DBConnectionInterface
{
    public function getConnection();
}