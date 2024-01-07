<?php

declare(strict_types=1);

namespace App\Elasticsearch;

interface CommandActionInterface
{
    public function do(): void;
    public function getMessage(): string;
    public function getError(): string | null;
}
