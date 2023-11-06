<?php
require_once(__DIR__.'/../vendor/autoload.php');

// Test MySQL
$db = mysqli_connect('otus-mysql', 'root', 'root', 'mysql');
$res = mysqli_query($db, "SHOW TABLES");
if ($res !== false && mysqli_num_rows($res) > 0) {
	echo 'MySQL OK.';
}
else {
	echo 'MySQL ERROR.';
}
echo '<br />';
mysqli_close($db);

// Test redis
$redisClient = new Predis\Client([
	'host' => 'otus-redis',
	'port' => 6379,
]);
$redisClient->set('foo', 'bar');
echo $redisClient->get('foo') ? 'Redis OK.' : 'Redis ERROR.';
echo '<br />';

// Test memcached
$memcached = new Memcached();
$memcached->addServer('otus-memcached', 11211);
$memcached->add('memcached_key', 'test');
echo $memcached->get('memcached_key') ? 'Memcached OK.' : 'Memcached ERROR.';
echo '<br />';

echo '<hr />';

phpinfo();
