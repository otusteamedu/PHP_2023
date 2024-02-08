<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain;


interface RenderStrategyInterface
{
    public function render(FileSystemItemInterface $fileSystemItem): string;
}
