<?php
declare(strict_types=1);

interface DatabaseAdapterInterface
{
    public function selectAll(string $table): Generator;
}