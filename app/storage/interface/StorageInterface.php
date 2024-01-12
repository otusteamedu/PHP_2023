<?php

declare(strict_types=1);

namespace Storage\Interface;

interface StorageInterface
{
    public function buildClient(): void;

    public function getKey(array $conditions): string;

    public function get(string $key): array | null;

    public function getAll(): array;

    public function add(string $key, int $score, string $events): int | null;

    public function hasKey(string $key, string $event): bool | int;

    public function delete(string $key): bool | int;
}
