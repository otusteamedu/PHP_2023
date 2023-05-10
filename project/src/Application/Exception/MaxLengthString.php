<?php

declare(strict_types=1);

namespace Vp\App\Application\Exception;

use Exception;
use Vp\App\Application\Exception\Contract\HandlerExceptionInterface;

class MaxLengthString extends Exception implements HandlerExceptionInterface
{
}
