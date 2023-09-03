<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\AudioProcessing;

use VKorabelnikov\Hw16\MusicStreaming\Application\AudioProcessing\AudioFileProcessor;
use falahati\PHPMP3\MpegAudio;

class Mp3FileProcessor implements AudioFileProcessor
{
    protected string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }


    public function getTrackDuration(): int
    {
        return (int) MpegAudio::fromFile($this->filePath)->getTotalDuration();
    }

    public function getFileProperties(): array
    {
        return [];
    }
}
