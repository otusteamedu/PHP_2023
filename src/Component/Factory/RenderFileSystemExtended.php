<?php
declare(strict_types=1);

namespace App\Component\Factory;

use App\Component\Strategy\RenderDirectoryRowExtended;
use App\Component\Strategy\RenderDirectoryRowInterface;
use App\Component\Strategy\RenderFileRowExtended;
use App\Component\Strategy\RenderFileRowInterface;

class RenderFileSystemExtended implements RenderFileSystemFactoryInterface
{

    public function createRenderDirectoryRow(): RenderDirectoryRowInterface
    {
        return new RenderDirectoryRowExtended();
    }

    public function createRenderFileRow(): RenderFileRowInterface
    {
        return new RenderFileRowExtended();
    }
}
