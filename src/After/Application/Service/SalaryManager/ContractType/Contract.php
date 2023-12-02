<?php

declare(strict_types=1);

namespace App\After\Application\Service\SalaryManager\ContractType;

enum Contract: string {
    case GPH = 'ГПХ';
    case TD = 'ТД';
    case EP = 'ИП';
    case SELF = 'Самозанятый';
}
