<?php

declare(strict_types=1);

namespace Girevik1\SubstrComposerPackage;

class TextFormater
{
    public function foo()
    {
        $textFormat = new PerfectText();

        $text = 'Дома в пять утра (как факт иногда). Я работал допоздна, контракт на словах';

        $textResult = $textFormat->getNeedFormatText($text, 10, '...');

        echo $textResult;
    }
}
