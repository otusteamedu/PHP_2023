<?php

declare(strict_types=1);

namespace App\Lib\Audio;

class File
{
    private int $duration;

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return $this
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

}
