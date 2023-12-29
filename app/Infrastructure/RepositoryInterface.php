<?php

namespace App\Infrastructure;

interface RepositoryInterface
{
    public function init(): void;
    public function addWithParams(string $element, int $score, int $p1, int $p2): void;
    public function clearAllEvents(): void;
    public function getFirstPrioritized(array $filter): string;
}
