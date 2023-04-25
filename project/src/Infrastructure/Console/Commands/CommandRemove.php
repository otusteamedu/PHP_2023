<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\RemoveDataInterface;

class CommandRemove implements CommandInterface
{
    private RemoveDataInterface $removeData;

    public function __construct(RemoveDataInterface $removeData)
    {
        $this->removeData = $removeData;
    }

    public function run(string $object): void
    {
        $result = $this->removeData->remove((int)$object);

        echo $result->getMessage();
    }
}
