<?php

declare(strict_types=1);

namespace App\Lib\Audio;

interface CompositeAudioInterface
{
    public function getDuration(): int;
    public function toArray(): array;
}
