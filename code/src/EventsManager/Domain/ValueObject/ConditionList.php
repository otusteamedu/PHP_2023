<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Domain\ValueObject;

class ConditionList
{
    private array $conditions;

    public function __construct(array $conditions)
    {
        $this->assertValidConditions($conditions);
        $this->conditions = $conditions;
    }

    private function assertValidConditions(array $conditions): void
    {
        if (empty($conditions)) {
            throw new \Exception("Список условий пуст.");
        }

        foreach ($conditions as $conditionValue) {
            if (empty($conditionValue)) {
                throw new \Exception("Одно из условий пусто.");
            }
        }
    }

    public function getValue(): array
    {
        return $this->conditions;
    }
}
