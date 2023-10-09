<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

class TrackWithDurationInDescription extends TrackDecorator
{
    public function getDescription(): string
    {
        $description = $this->track->getDescription();
        $description .= "<br><br>  Duration: "
        . (empty($this->track->getDuration()) ? "unknown" : $this->track->getDuration());
        return $description;
    }
}
