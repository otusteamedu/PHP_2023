<?php

namespace Ad\Infrastructure;

use Ad\Domain\Ad;
use Ad\Domain\AdFile;
use FileStorage\Domain\Entity\File;

class ArrayPresenter
{
    public static function present(Ad $ad): array
    {
        return [
            'id' => $ad->getId(),
            'title' => $ad->getTitle(),
            'price' => $ad->getPrice(),
            'description' => $ad->getDescription(),
            'photo' => $ad->getPhoto()->map(function (AdFile $adF) {
                $photo = $adF->getFile();
                return [
                    'id' => $photo->getId(),
                    'path' => $photo->getPath(),
                    'type' => $photo->getType(),
                    'original_name' => $photo->getOriginalName(),
                    'size' => $photo->getSize(),
                ];
            })->toArray(),
            'status' => $ad->getStatus()->value,
        ];
    }
}
