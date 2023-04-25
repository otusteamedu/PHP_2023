<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\ListDataInterface;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class CommandList implements CommandInterface
{
    private ListDataInterface $listData;

    public function __construct(ListDataInterface $listData)
    {
        $this->listData = $listData;
    }

    /**
     * @throws MethodNotFound
     */
    public function run(string $object): void
    {
        switch ($object) {
            case 'employee':
                $result = $this->listData->list($object);
                $result->show();
                break;
            default:
                echo 'The object name is incorrect' . PHP_EOL;
        }
    }
}
