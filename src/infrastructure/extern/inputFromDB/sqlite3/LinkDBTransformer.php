<?php

namespace src\infrastructure\extern\inputFromDB\sqlite3;

use src\domain\entry\UserRow;

class LinkDBTransformer
{
    public static function transform(array $accData): array
    {
        $data = [];
        foreach ($accData as $key => $userData) {
            $data[$key] = new UserRow($userData['user'], $userData['event'], $userData['notify']);
        }

        return $data;
    }
}
