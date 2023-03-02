<?php

namespace Sva;

class FileReader
{
    public function getLines($file): \Generator
    {
        $f = fopen($file, 'r');
        try {
            while ($line = fgets($f)) {
                yield trim($line);
            }
        } finally {
            fclose($f);
        }
    }
}
