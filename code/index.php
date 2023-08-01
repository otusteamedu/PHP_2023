<h1>Hello, OTUS!</h1>
<?php

$lines = file($_SERVER['DOCUMENT_ROOT'].'/.env');

foreach($lines as $key => $value) {
    putenv(trim($value));
}

$redis = new Redis();

try {
    $redis->connect(getenv('REDIS_HOST'));
    echo "Успешно подключились к Redis.<br>";
} catch (RedisException $e) {
    echo $e->getMessage();
}

$memcached = new Memcached();


try {
    $memcached->addServer(getenv('MEMCACHED_HOST'), 11211);
    echo "Успешно подключились к Memcached";
} catch (MemcachedException $e) {
    echo $e->getMessage();
}
