<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\AudioProcessing;

use VKorabelnikov\Hw16\MusicStreaming\Application\AudioProcessing\AudioFileProcessor;

class WavFileProcessor implements AudioFileProcessor
{
    protected string $filePath;


    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }


    public function getTrackDuration(): int
    {
        $bytesPerSample = ($this->getBitsPerSaample() / 8);

        $numSamples = (
                $this->getAudioSize() / (
                    $this->getChannelsNumber() * $bytesPerSample
                )
            );

        return (int) ($numSamples / $this->getSampleRate());
    }

    public function getFileProperties(): array
    {
        return [];
    }

    protected function getAudioSize(): int
    {
        return unpack("i", file_get_contents(
            $this->filePath,
            false,
            null,
            40,
            4
        ))[1];
    }

    protected function getChannelsNumber(): int
    {
        return unpack("S", file_get_contents(
            $this->filePath,
            false,
            null,
            22,
            2
        ))[1];
    }

    protected function getSampleRate(): int
    {
        return unpack("i", file_get_contents(
            $this->filePath,
            false,
            null,
            24,
            4
        ))[1];
    }

    protected function getBitsPerSaample(): int
    {
        return unpack("S", file_get_contents(
            $this->filePath,
            false,
            null,
            34,
            2
        ))[1];
    }
}
