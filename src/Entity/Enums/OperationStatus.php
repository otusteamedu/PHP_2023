<?php
declare(strict_types=1);

namespace App\Entity\Enums;

enum OperationStatus: int
{
    case Running = 1;
    case Completed = 2;
}
