<?php

namespace Sva;

class FileReader
{
    function getLines($file): \Generator
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