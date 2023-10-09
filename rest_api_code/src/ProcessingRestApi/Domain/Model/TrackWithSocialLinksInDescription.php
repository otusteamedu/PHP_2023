<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

class TrackWithSocialLinksInDescription extends TrackDecorator
{
    public function getDescription(): string
    {
        $description = $this->track->getDescription();
        $description .= "<br><br>  Поделиться в соц сетях: <a href='...'>ссылка на соцсеть</a>";
        return $description;
    }
}
