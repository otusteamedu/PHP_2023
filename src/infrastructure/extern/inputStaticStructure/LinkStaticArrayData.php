<?php

namespace src\infrastructure\extern\inputStaticStructure;

use src\infrastructure\extern\FetchDataQueryInterface;
use src\infrastructure\extern\inputFromDB\sqlite3\LinkDBTransformer;

class LinkStaticArrayData implements FetchDataQueryInterface
{
    public function fetchAll(): array
    {
        $data = [
            ['user' => 1, 'event' => '1', 'notify' => '1', 'sort' => 1],
            ['user' => 1, 'event' => '1', 'notify' => '2', 'sort' => 1],
            ['user' => 1, 'event' => '2', 'notify' => '1', 'sort' => 2],
            ['user' => 1, 'event' => '2', 'notify' => '2', 'sort' => 1],
            ['user' => 2, 'event' => '1', 'notify' => '3', 'sort' => 2],
            ['user' => 2, 'event' => '2', 'notify' => '1', 'sort' => 1],
            ['user' => 2, 'event' => '2', 'notify' => '3', 'sort' => 1],
        ];

        return LinkDBTransformer::transform($data);
    }

    public function fetchUserSubscribes(): array
    {
        return [
            ['user' => 1, 'type' => 'mail', 'value' => 'tester@box.zn'],
            ['user' => 1, 'type' => 'phone', 'value' => 'numb-01'],
            ['user' => 1, 'type' => 'telegram', 'value' => '@testerChannel'],
        ];
    }

    public function fetchNotify(): array
    {
        return [
            ['uid' => 1, 'name' => 'sms'],
            ['uid' => 2, 'name' => 'mail'],
            ['uid' => 3, 'name' => 'telegram1'],
        ];
    }

    public function fetchEvent(): array
    {
        return [
            ['uid' => 1, 'name' => 'meet'],
            ['uid' => 2, 'name' => 'party'],
        ];
    }

    public function fetchUsers(): array
    {
        return [
            ['uid' => 1, 'name' => 'Tester',],
            ['uid' => 2, 'name' => 'Demo',],
        ];
    }
}
