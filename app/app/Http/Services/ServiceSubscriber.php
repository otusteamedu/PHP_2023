<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\Subscriber;

class ServiceSubscriber
{
    private Subscriber $subscriber;

    /**
     * @param Subscriber $subscriber
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function add(array $data): void
    {
        $this->subscriber->create([
            'user_id' => $data['user_id'],
            'genre_id' => $data['genre_id'],
        ]);
    }
}
