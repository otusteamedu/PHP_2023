<?php

declare(strict_types=1);

namespace App\Lib\Wav;

class Parser
{
    const HEADER_LENGTH = 44;
    const OFFSET = 28;

    private string $filePath;
    private float $duration;
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->parseFileInfo();
    }

    protected function parseFileInfo(): void
    {
        $fp = fopen($this->filePath, 'rb');
        fseek($fp, self::OFFSET);
        $header = unpack('Vbytespersec',fread($fp, 4));

        $this->duration = (filesize($this->filePath) - self::HEADER_LENGTH) / $header['bytespersec'];
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }
}
