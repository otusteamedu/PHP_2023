<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain;

interface FileSystemItemFactoryInterface
{
    public function makeFile($name): FileSystemItemInterface;

    public function makeDirectory($name, $level): FileSystemItemInterface;
}
