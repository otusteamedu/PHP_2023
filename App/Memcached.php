<?php

namespace App;

use Memcached as MemcachedClient;

class Memcached
{
    public static function test()
    {
        $mc = new MemcachedClient();
        $mc->addServer('memcached', '11211');
        $mc->add('test', 'success');
        return $mc->get('test');
    }
}
