<?php

declare(strict_types=1);

namespace App\Lib\Track;

use App\Lib\Subscriber\SubscriberObserverInterface;
use App\Lib\Subscriber\SubscriberSubjectInterface;
use App\Models\Track;
use SplObjectStorage;

class TrackAdd implements SubscriberSubjectInterface
{
    private TrackObject $trackObject;
    private Track $trackModel;
    private SplObjectStorage $observers;

    /**
     * @param TrackObject $trackObject
     */
    public function __construct(Track $trackModel, TrackObject $trackObject)
    {
        $this->trackModel = $trackModel;
        $this->trackObject = $trackObject;
        $this->observers = new SplObjectStorage();
    }

    public function execute():void
    {
        $this->trackModel->create([
            'name' => $this->trackObject->getName(),
            'author' => $this->trackObject->getAuthor(),
            'genre_id' => $this->trackObject->getGenre(),
            'duration' => $this->trackObject->getDuration(),
            'file' => $this->trackObject->getFile(),
        ]);

        $this->notify($this->trackObject);
    }

    public function attach(SubscriberObserverInterface $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SubscriberObserverInterface $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(TrackObject $trackObject): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($trackObject);
        }
    }
}
