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

print 'Mysql Check: ';
try {
    if (class_exists('Mysqli')) {
        $mysqli = new Mysqli(
            'mysql',
            'singurix',
            'VQu44)wBLQ',
            'singurixDB',
            3306
        );
        print 'Mysql version ' . $mysqli->server_info . ' ✓<br>';
    } else {
        throw new Exception('Class "Mysqli" not found<br>');
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
