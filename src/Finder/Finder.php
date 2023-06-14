<?php

declare(strict_types=1);

namespace Otus\App\Finder;

final class Finder
{
    public function exists(string $filename): bool
    {
        return file_exists($filename);
    }

    public function delete(string $filename): void
    {
        if ($this->exists($filename)) {
            unlink($filename);
        }
    }
}
