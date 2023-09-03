<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\UseCase;

use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\GenreMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\UserMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\TrackMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\TrackWithSocialLinksInDescription;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\TrackWithDurationInDescription;


class FindTrackUseCase
{
    protected GenreMapperInterface $genreMapper;
    protected UserMapperInterface $userMapper;
    protected TrackMapperInterface $trackMapper;

    public function __construct(
        GenreMapperInterface $genreMapper,
        UserMapperInterface $userMapper,
        TrackMapperInterface $trackMapper
    )
    {
        $this->genreMapper = $genreMapper;
        $this->userMapper = $userMapper;
        $this->trackMapper = $trackMapper;
    }

    public function bygenre(array $findParams): array
    {
        $genreName = $findParams["genreName"];
        $itemsPerPage = $findParams["itemsPerPage"];
        $pageNumber = $findParams["pageNumber"];
        $setAdditionalDescription = $findParams["setAdditionalDescription"];

        $genre = $this->genreMapper->findByName($genreName);

        $tracksList = $this->trackMapper->findByGenre(
            $genre,
            $itemsPerPage,
            $itemsPerPage * ($pageNumber - 1)
        );
        if($setAdditionalDescription === true) {
            $tracksList = $this->decorateTracksSocial(
                $this->decorateTracksDuration($tracksList)
            );
        }

        return $tracksList;
    }

    protected function decorateTracksSocial(array $tracksList): array
    {
        $decoratedTracks = [];
        foreach($tracksList as $track) {
            $decoratedTracks[] = new TrackWithSocialLinksInDescription($track);
        }

        return $decoratedTracks;
    }

    protected function decorateTracksDuration(array $tracksList): array
    {
        $decoratedTracks = [];
        foreach($tracksList as $track) {
            $decoratedTracks[] = new TrackWithDurationInDescription($track);
        }

        return $decoratedTracks;
    }
}
