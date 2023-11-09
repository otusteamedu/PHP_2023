<?php

namespace src\extern\inputFromDB;

use src\extern\inputFromDB\sqlite3\LinkDBTransformer;
use src\extern\inputFromDB\sqlite3\Sqlite3DataProvider;
use src\interface\FetchableArrayInterface;

class LinkDBData implements FetchableArrayInterface {
    public function fetch(): array {
        $accData = Sqlite3DataProvider::create()
//        $accData = IoCDataProvider::create(
//            Sqlite3DataProvider::class
//        )->create()
            ->fetch()
            ->getData();
        //@fixme effective provide array
        return LinkDBTransformer::transform($accData);
    }
}
