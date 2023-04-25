<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\GetDataInterface;

class CommandGet implements CommandInterface
{
    private GetDataInterface $getData;

    public function __construct(GetDataInterface $getData)
    {
        $this->getData = $getData;
    }

    public function run(string $object): void
    {
        $result = $this->getData->get($object);

        if ($result->isSuccess()) {
            $result->show();
            return;
        }

        echo $result->getMessage();
    }
}
