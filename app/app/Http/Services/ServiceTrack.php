<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Lib\Audio\Adapter;
use App\Lib\Subscriber\SubscriberEmailNotification;
use App\Lib\Track\TrackAdd;
use App\Lib\Track\TrackBuilder;
use App\Lib\Track\TrackItems;
use App\Lib\Track\TrackObject;
use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class ServiceTrack
{
    public const PATH_STORE_FILE = 'tracks';
    private Track $track;
    private SubscriberEmailNotification $subscriberEmailNotification;

    public function __construct(
        Track $track,
        SubscriberEmailNotification $subscriberEmailNotification
    ) {
        $this->track = $track;
        $this->subscriberEmailNotification = $subscriberEmailNotification;
    }

    public function add(array $data): void
    {
        /** @var UploadedFile $file */
        $file = $data['file'];
        $audioParser = new Adapter($file);
        $audioParser->readFile()->getFile();
        $data['duration'] = $audioParser->getFile()->getDuration();
        $data['filepath'] = $file->store(self::PATH_STORE_FILE);

        $trackBuilder = new TrackBuilder(
            $data['name'],
            $data['author'],
            (int)$data['genre_id'],
            $data['duration'],
            $data['filepath'],
        );
        $trackObject = new TrackObject($trackBuilder);

        $trackAdd = new TrackAdd($this->track, $trackObject);
        $trackAdd->attach($this->subscriberEmailNotification);
        $trackAdd->execute();
    }

    /**
     * @param int $genre
     * @return TrackItems
     */
    public function getByGenre(int $genre): TrackItems
    {
        $list = [];
        $trackList = $this->track->where('genre_id', $genre)->get();
        /** @var Track $track */
        foreach ($trackList as $track) {
            $builder = new TrackBuilder(
                $track->getAttribute('name'),
                $track->getAttribute('author'),
                (int)$track->getAttribute('genre_id'),
                (int)$track->getAttribute('duration'),
                $track->getAttribute('file')
            );
            $list[] = $builder->build();
        }
        return new TrackItems($list);
    }

    /**
     * @return Collection|Track[]
     */
    public function getAll(): Collection
    {
        return $this->track->all();
    }
}
