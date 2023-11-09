<?php

namespace src\Exception;

use src\inside\DataArray;

class IoC
{
    private DataArray $dataList;

    public function __construct()
    {
        $this->dataList = DataArray::build();
    }

    public static function build(): self
    {
        return new self();
    }

    private function getDataList(): DataArray
    {
        return $this->dataList;
    }

    public function matchCommand(string $exception): CommandInterface
    {
        $this->make();
        if (!$this->getDataList()->hasByKey($exception)) {
            return (new NonexistentImplementationExceptionCommand());
        }
        //try {
        //    $command = $this->getDataList()->getByKey($exception);
        //    return $command;
        //} catch (Exception $exception) {
        //    IoC::build()->getCommand($exception)->do($exception);
        //    return new NullExceptionCommand();
        //}

        return $this->getDataList()->getByKey($exception);
    }

    private function make()
    {
        $this->getDataList()->addByKey(
            NonexistentImplementationException::class,
            new NonexistentImplementationExceptionCommand()
        );

        $this->getDataList()->addByKey(
            GreetingNullException::class,
            new GreetingNullExceptionCommand()
        );

        $this->getDataList()->addByKey(
            EmptyKeyForDataListException::class,
            new EmptyKeyForDataListExceptionCommand()
        );

        $this->getDataList()->addByKey(
            GreetingNonexistentException::class,
            new GreetingNonexistentExceptionCommand()
        );
    }
}
