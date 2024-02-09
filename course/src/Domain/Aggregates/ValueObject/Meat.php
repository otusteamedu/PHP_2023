<?php

namespace Cases\Php2023\Domain\Aggregates\ValueObject;

use InvalidArgumentException;

class Meat
{
    const TYPE_BEEF = 'beef';
    const TYPE_CHICKEN = 'chicken';
    const TYPE_PORK = 'pork';
    const TYPE_TURKEY = 'turkey';
    const TYPE_VEGETARIAN = 'vegetarian';

    private $type;

    public function __construct($type)
    {
        $this->setType($type);
    }

    private function setType($type)
    {
        $validTypes = [
            self::TYPE_BEEF,
            self::TYPE_CHICKEN,
            self::TYPE_PORK,
            self::TYPE_TURKEY,
            self::TYPE_VEGETARIAN
        ];
        if (!in_array($type, $validTypes)) {
            throw new InvalidArgumentException('Invalid meat type');
        }
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}