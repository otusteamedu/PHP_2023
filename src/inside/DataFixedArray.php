<?php

namespace src\inside;

use SplFixedArray;
use src\Exception\GreetingNonexistentException;
use src\inside\typeClass\IntClass;

class DataFixedArray { //@fixme add interface
    private SplFixedArray $dataFixedList;
    //ToDO
    //SplFixedArray::setSize — Изменяет размер массива
    //SplFixedArray::offsetSet — Устанавливает новое значение по заданному индексу
    //SplFixedArray::toArray — Возвращает обычный PHP-массив со значениями фиксированного массива
    //SplFixedArray::offsetExists — Возвращает факт наличия указанного индекса массива

    public function fromArray(array $pieces): self {
        $this->setDataFixedList(SplFixedArray::fromArray($pieces));
        return $this;
    }

    public static function build(): self {
        return new self();
    }

    public function hasByKey($key): bool {
        return $this->getDataFixedList()->offsetExists($key);
    }

    public function getByKey($key) {
        return $this->getDataFixedList()->offsetGet($key);
    }

    /**
     * @throws GreetingNonexistentException
     */
    public function getByKeyOrException(IntClass $key) {
        //return $this->getByKey($key) ?? throw new GreetingNonexistentException('key::' . $key);
        return $this->dataFixedList[ $key->toInt() ] ??
            throw new GreetingNonexistentException('key::' . $key->toInt());
    }

    private function getDataFixedList(): SplFixedArray {
        return $this->dataFixedList;
    }

    private function setDataFixedList(SplFixedArray $dataFixedList): void {
        $this->dataFixedList = $dataFixedList;
    }
}
