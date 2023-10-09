<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\AudioProcessing;

interface AudioFileProcessor
{
    public function getTrackDuration(): int;
    public function getFileProperties(): array;
}
