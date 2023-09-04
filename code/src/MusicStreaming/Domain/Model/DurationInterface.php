<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

interface DurationInterface
{
    public function getDuration(): string;
    public function getDurationSeconds(): int;
}
