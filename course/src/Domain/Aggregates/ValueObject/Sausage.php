<?php

namespace Cases\Php2023\Domain\Aggregates\ValueObject;


use InvalidArgumentException;

class Sausage
{
    const SAUCE_KETCHUP = 'ketchup';
    const SAUCE_MAYONNAISE = 'mayonnaise';
    const SAUCE_KETCHUNNAISE = 'ketchunnaise';

    private $type;


    public function __construct($type)
    {
        $this->setType($type);
    }

    private function setType($type)
    {
        $allowedSauces = [self::SAUCE_KETCHUP, self::SAUCE_MAYONNAISE, self::SAUCE_KETCHUNNAISE];
        if (!in_array($type, $allowedSauces)) {
            throw new InvalidArgumentException('Invalid sauce type');
        }
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}
