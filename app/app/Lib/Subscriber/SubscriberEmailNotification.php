<?php

declare(strict_types=1);

namespace App\Lib\Subscriber;

use App\Lib\Track\TrackObject;
use App\Models\Subscriber;

class SubscriberEmailNotification implements SubscriberObserverInterface
{
    private Subscriber $subscriberModel;

    /**
     * @param Subscriber $subscriberModel
     */
    public function __construct(Subscriber $subscriberModel)
    {
        $this->subscriberModel = $subscriberModel;
    }

    public function update(TrackObject $trackObject): void
    {
        $subscribers = $this->subscriberModel->where('genre_id', $trackObject->getGenre())->get();
        foreach ($subscribers as $subscriber) {
            //todo: тут будет отправка email
            // $subscriber->user()->first()
        }
    }

}
