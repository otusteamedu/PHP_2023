<?php

namespace Ndybnov\Hw05\hw;

use NdybnovHw03\CnfRead\Storage;

class ArgumentsCommandLine
{
    public static function getParameters(): Storage
    {
        $parameters = new Storage();
        $parameters->fromArray([
            'type' => $_SERVER['argv'][1] ?? 'server',
            'cmd' => $_SERVER['argv'][2] ?? '',
        ]);

        return $parameters;
    }
}
