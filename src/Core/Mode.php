<?php

declare(strict_types=1);

namespace Twent\Chat\Core;

enum Mode: string
{
    case Server = 'server';
    case Client = 'client';
}
