<?php

declare(strict_types=1);

namespace App\Lib\Audio;

use App\Lib\Wav\Parser;
use Illuminate\Http\UploadedFile;
use wapmorgan\Mp3Info\Mp3Info;

class Adapter
{
    public const AUDIO_MP3 = 'audio/mpeg';
    public const AUDIO_WAV = 'audio/wave';
    public const AUDIO_X_WAV = 'audio/x-wav';

    private UploadedFile $inputFile;

    private File $file;

    public function __construct(UploadedFile $inputFile)
    {
        $this->inputFile = $inputFile;
        $this->file = new File();
    }

    public function readFile(): self
    {
        switch ($this->inputFile->getMimeType()) {
            case self::AUDIO_MP3:
                $audioParser = new Mp3Info($this->inputFile->getRealPath(), true);
                $duration = $audioParser->duration;
                break;

            case self::AUDIO_WAV:
            case self::AUDIO_X_WAV:
                $audioParser = new Parser($this->inputFile->getRealPath());
                $duration = $audioParser->getDuration();
                break;

            default:
                throw new \Exception('Неизвестный формат файла');
        }

        $this->file->setDuration((int)$duration);

        return $this;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

}
