<?php

namespace IilyukDmitryi\App\Infrastructure\UuidGenerator;

use IilyukDmitryi\App\Application\Contract\UuidGenerator\UuidGeneratorInterface;

class SimpleGenerator implements UuidGeneratorInterface
{
    public static function generate(array $parameters=[]): string
    {
        $prefix = '';
        if(isset($parameters['prefix'])){
            $prefix = $parameters['prefix'];
        }
        return uniqid($prefix);
    }
}