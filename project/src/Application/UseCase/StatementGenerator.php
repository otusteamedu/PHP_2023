<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\UseCase\Contract\StatementGeneratorInterface;

class StatementGenerator implements StatementGeneratorInterface
{
    public function generate(string $dateStart, string $dateEnd): string
    {
        $statement = 'Дата начала отчета: ' . $dateStart . PHP_EOL;
        $statement .= 'Дата окончания отчета: ' . $dateEnd . PHP_EOL;
        $statement .= 'Текст отчета: здесь выводится текст отчета' . PHP_EOL;
        return $statement;
    }
}
