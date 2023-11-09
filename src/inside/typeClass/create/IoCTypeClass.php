<?php

namespace src\inside\typeClass\create;

use src\inside\DataFixedArray;
use src\inside\typeClass\CustomizableInterface;
use src\inside\typeClass\fetch\Classes;

class IoCTypeClass
{
    private DataFixedArray $dataList;

    public static function build(): self
    {
        return new self();
    }

    public function create(string $name): CustomizableInterface
    {
        return $this
            ->makeDataList()
            ->getDataList()->getByKey($name);
    }

    private function makeDataList(): self
    {
        $this->setDataList(
            DataFixedArray::build()
                ->fromArray(Classes::fetch())
        );
        // @todo hided add value with exception
        return $this;
    }

    private function getDataList(): DataFixedArray
    {
        return $this->dataList;
    }

    private function setDataList(DataFixedArray $dataList): void
    {
        $this->dataList = $dataList;
    }
}
