<?php

namespace old\code\src\NewCode\Domain\ValueObject;

class Step
{
    private int $step;

    /**
     * @throws \Exception
     */
    public function __construct(int $step)
    {
        $this->assertValidStep($step);
        $this->step = $step;
    }

    /**
     * @throws \Exception
     */
    private function assertValidStep(int $step): void
    {
        if ($step <= 0 || $step > 10_000) {
            throw  new \InvalidArgumentException('Шаг торгов должен быть больше 0 и менее 10 000');
        }
    }

    public function getValue(): int
    {
        return $this->step;
    }

    public function __toString(): string
    {
        return $this->step;
    }
}
