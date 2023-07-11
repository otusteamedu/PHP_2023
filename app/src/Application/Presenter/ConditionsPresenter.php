<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Presenter;

use Imitronov\Hw12\Domain\ValueObject\Condition;

final class ConditionsPresenter
{
    /**
     * @param Condition[] $conditions
     */
    public function present(array $conditions): array
    {
        $result = [];

        foreach ($conditions as $condition) {
            $result[$condition->getKey()] = $condition->getValue();
        }

        return $result;
    }
}
