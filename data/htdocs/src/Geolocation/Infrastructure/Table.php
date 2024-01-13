<?php

namespace Geolocation\Infrastructure;

class Table
{
    public static function createTable()
    {
        $db = container()->get(\PDO::class);
        $db->exec('CREATE TABLE IF NOT EXISTS city (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            latitude FLOAT NOT NULL,
            longitude FLOAT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )');
    }

    public static function dropTable()
    {
        $db = container()->get(\PDO::class);
        $db->exec('DROP TABLE IF EXISTS city');
    }
}
