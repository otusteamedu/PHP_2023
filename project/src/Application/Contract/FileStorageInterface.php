<?php
declare(strict_types=1);

namespace Vp\App\Application\Contract;

interface FileStorageInterface
{
    public function getPathFile(string $fileName): ?string;
}
