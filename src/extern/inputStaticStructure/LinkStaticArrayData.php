<?php

namespace src\extern\inputStaticStructure;

use src\extern\FetchArrayInterface;
use src\extern\FetchDataArrayInterface;

class LinkStaticArrayData implements FetchArrayInterface, FetchDataArrayInterface
{
    public function fetch(): array
    {
        return [
            1 => [
                'concert' => ['mail'],
                'exhibition' => ['sms', 'mail',]
            ],

            2 => [
                'competition' => ['sms', 'mail', 'facebook']
            ],

            3 => [
                'pub' => ['sms'],
                'concert' => ['mail', 'non-exist-notify-way', 'telegram'],
                'exhibition' => ['sms', 'mail',]
            ],

            4 => [
                'pub' => ['sms'],
                'concert' => ['non-exist-notify-way', 'telegram', 'mail'],
            ],
        ];
    }

    public function fetchData(string $userId, string $eventType): array
    {
        return $this->fetch();
    }
}
