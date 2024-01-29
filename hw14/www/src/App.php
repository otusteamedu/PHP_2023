<?php

namespace Shabanov\Otusphp;

class App
{
    private const TASK1_DATA_LIST = [3, 2, 0, -4];
    private const TASK1_POS_CYCLE = 1;
    private const TASK2_DIGIST = '3';
    public function __construct() {}

    public function run(): void
    {
        /*
        * task1: Cycle in NodeList
        */
        echo (new Render())
            ->showCycleInList($this->isCycleInList());

        /*
        * task2: Generate Letters from Numbers Phone
        */
        echo (new Render())
            ->showGenerateLetters($this->digitsGenerate());
    }

    private function isCycleInList(): bool
    {
        $nodeHead = NodeList::setFromArray(self::TASK1_DATA_LIST, self::TASK1_POS_CYCLE);
        return NodeList::hasCycle($nodeHead);
    }

    private function digitsGenerate(): array
    {
        return (new Digits(self::TASK2_DIGIST))
            ->generate(0);
    }
}
