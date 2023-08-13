<?php

namespace Ro\Php2023\Entities;

interface ConditionInterface
{
    public function getName(): string;
    public function getValue(): int|string;
}