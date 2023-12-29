<?php

namespace App\Application\Helper;

class ReadDataHelper
{
    public function doing(): array
    {
        $file = __DIR__ . '/../../../data/events.json';
        if (!\file_exists($file)) {
            exit();
        }

        return \json_decode(\file_get_contents($file), true);
    }
}
