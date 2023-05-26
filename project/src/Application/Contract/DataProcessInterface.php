<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use PhpAmqpLib\Message\AMQPMessage;

interface DataProcessInterface
{
    public function process(AMQPMessage $msg): void;
}
