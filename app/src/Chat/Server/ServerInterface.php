<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\Chat\Server;

interface ServerInterface
{
    public function run(): void;
    public function prepareAnswer(string $data): string;
}