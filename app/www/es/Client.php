<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;

class Client
{
    public static $instance = null;

    public static function connect()
    {
        if (!self::$instance) {
            self::$instance = ClientBuilder::create()
                                                ->setHosts(['elasticsearch:9200'])
                                                ->build();
        }

        return self::$instance;
    }
}
