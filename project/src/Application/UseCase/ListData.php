<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Illuminate\Database\Eloquent\Collection;
use Vp\App\Application\Contract\ListDataInterface;
use Vp\App\Application\Dto\Output\ResultList;
use Vp\App\Domain\Model\Employee;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class ListData implements ListDataInterface
{
    /**
     * @throws MethodNotFound
     */
    public function list(string $context): ResultList
    {
        $methodName = __FUNCTION__ . ucfirst($context);

        if (!method_exists($this, $methodName )) {
            throw new MethodNotFound('Method not found');
        }

        $result = $this->{$methodName}();

        return new ResultList($result);
    }

    private function listEmployee(): Collection
    {
        return Employee::all();
    }
}
