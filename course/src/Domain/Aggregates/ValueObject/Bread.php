<?php

namespace Cases\Php2023\Domain\Aggregates\ValueObject;

use InvalidArgumentException;

class Bread
{
    const TYPE_WHITE = 'white';
    const TYPE_WHEAT = 'wheat';
    const TYPE_RYE = 'rye';
    const TYPE_SOURDOUGH = 'sourdough';
    const TYPE_GLUTEN_FREE = 'gluten-free';

    private $type;

    public function __construct($type)
    {
        $this->setType($type);
    }

    private function setType($type)
    {
        $validTypes = [
            self::TYPE_WHITE,
            self::TYPE_WHEAT,
            self::TYPE_RYE,
            self::TYPE_SOURDOUGH,
            self::TYPE_GLUTEN_FREE
        ];
        if (!in_array($type, $validTypes)) {
            throw new InvalidArgumentException('Invalid bread type');
        }
        $this->type = $type;
    }


    public function getType()
    {
        return $this->type;
    }
}