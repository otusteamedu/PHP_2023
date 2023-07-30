<?php

namespace IilyukDmitryi\App\Application\Contract\UuidGenerator;

interface UuidGeneratorInterface
{
    public static function generate(array $parameters = []): string;
}
