<?php

namespace Shabanov\Otusphp;

class Render
{
    public function __construct() {}

    public function showCycleInList(bool $isCycle): string
    {
        if (!empty($isCycle)) {
            return 'Связанный список содержит зацикливание' . PHP_EOL;
        }
        return 'Связанный список НЕ содержит зацикливания' . PHP_EOL;
    }

    public function showGenerateLetters(array $letters): string
    {
        if (!empty($letters)) {
            $result = '';
            foreach($letters as $k=>$letter) {
                $result .= $k . '. ' . $letter . PHP_EOL;
            }
            return $result . PHP_EOL;
        }
        return 'Пустота' . PHP_EOL;
    }
}
