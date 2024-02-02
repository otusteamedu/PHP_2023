<?php

namespace Dimal\Hw11\Domain\Entity;

class BookAvailable
{
    private array $avail;

    public function __construct($avail)
    {
        foreach ($avail as $shop) {
            $this->avail[$shop['shop']] = $shop['stock'];
        }
    }

    public function getShopCountToString(): string
    {
        $result = '';
        foreach ($this->avail as $shop => $count) {
            if ($count) {
                $result .= $shop . ': ' . $count . ', ';
            }
        }
        return substr($result, 0, -2);
    }
}