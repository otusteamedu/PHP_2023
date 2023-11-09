<?php

namespace src\service\link\source;

use src\interface\FetchableArrayInterface;

class IoCFetchableSource {
    public static function create(string $class) : FetchableArrayInterface {
        return new $class();
    }
}
