<?php
declare(strict_types=1);

namespace App\Component\Factory;

use App\Component\Strategy\RenderDirectoryRowInterface;
use App\Component\Strategy\RenderFileRowInterface;

interface RenderFileSystemFactoryInterface
{
    public function createRenderDirectoryRow(): RenderDirectoryRowInterface;

    public function createRenderFileRow(): RenderFileRowInterface;
}
