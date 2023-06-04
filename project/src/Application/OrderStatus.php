<?php

declare(strict_types=1);

namespace Vp\App\Application;

enum OrderStatus
{
    case created;
    case assembly;
    case delivery;
    case delivered;
}
