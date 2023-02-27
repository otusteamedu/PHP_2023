<?php

declare(strict_types=1);

namespace Twent\Chat\Sockets;

use Stringable;

final class UnixSocket implements Stringable
{
    public function __construct(
        private readonly string $path
    ) {
        if ($this->exists()) {
            $this->remove();
        }
    }

    public function __toString(): string
    {
        return $this->path;
    }

    public function exists(): bool
    {
        return file_exists($this->path);
    }

    public function remove(): bool
    {
        return unlink($this->path);
    }
}
