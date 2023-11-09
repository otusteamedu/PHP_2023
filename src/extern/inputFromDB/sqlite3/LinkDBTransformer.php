<?php

namespace src\extern\inputFromDB\sqlite3;

class LinkDBTransformer {
    public static function transform(array &$accData): array {
        $dt = [];
        foreach ($accData as $val) {
            $dt[ $val['id'] ] = self::modify($val);
        }

        return $dt;
    }

    private static function modify(array &$row): array {
        return [
            self::name($row[ 'name' ]),
            'aliases' => self::aliases($row[ 'aliases' ]),
            'with_name'=> $row[ 'with_name' ] ? '+' : '',
            'active' => $row[ 'active' ] ?? 0
        ];
    }

    private static function name(string $source): string {
        return str_replace(["\'", "'"], '', $source);
    }

    private static function aliases(string $source): array {
        $als = explode(',', $source);
        $synonyms = [];
        foreach ($als as $al) {
            $item = str_replace(["\'", "'", "/'", " "], '', $al);
            $synonyms[] = $item;
        }

        return $synonyms;
    }
}
