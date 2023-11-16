<?php

namespace src\extern\inputFromDB\sqlite3;

class LinkDBTransformer
{
    public static function transform(array $accData): array
    {
        $dt = [];
        foreach ($accData as $val) {
            $dt[$val['user_id']][$val['event']][] = $val['notify'];
        }

        return $dt;
    }
}
