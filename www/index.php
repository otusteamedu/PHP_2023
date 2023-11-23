<?php

print 'Redis Check: ';
try {
    if (class_exists('Redis')) {
        $redis = new Redis();
        $redis->connect('redis', 6379);
        $info = $redis->info();
        print 'Redis version ' . $info['redis_version'] . ' ✓<br>';
    } else {
        throw new Exception('Class "Redis" not found<br>');
    }
} catch (Exception $e) {
    print $e->getMessage();
}

print 'Memcache Check: ';
try {
    if (class_exists('Memcache')) {
        $memcache = new Memcache();
        $memcache->connect('memcached', 11211);
        print 'Memcache version ' . $memcache->getVersion() . ' ✓<br>';
    } else {
        throw new Exception('Class "Memcache" not found<br>');
    }
} catch (Exception $e) {
    print $e->getMessage();
}

print 'Postgresql Check: ';
try {
    if (function_exists('pg_connect') && $dbconn = pg_connect('host=db port=5432 user=postgres password=postgres')) {
        $pgdata = pg_version($dbconn);
        print 'Postgres version ' . $pgdata['client'] . ' ✓<br>';
    } else {
        throw new Exception('Connection fail<br>');
    }
} catch (Exception $e) {
    print $e->getMessage();
}

print 'Composer Check: ';
try {
    system('composer --version');
    print '✓';
} catch (Exception $e) {
    print $e->getMessage();
}
