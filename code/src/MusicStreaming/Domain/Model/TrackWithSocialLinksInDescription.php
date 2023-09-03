<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

class TrackWithSocialLinksInDescription extends TrackDecorator
{
    public function getDescription(): string
    {
        $description = $this->track->getDescription();
        $description .= "<br><br>  Follow us in social media!";
        return $description;
    }
}
