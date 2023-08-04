<?php

namespace src\public;

require '../vendor/autoload.php';

use Memcache;
use Nette\Database\Connection;
use Redis;
use src\domain\DBStorageDTO;
use src\domain\FabricCaching;
use src\domain\StorageDTO;
use Symfony\Component\Dotenv\Dotenv;

$EOL = '<br/>';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$redisHost = $_ENV[ 'REDIS_HOST' ];
$redisPort = $_ENV[ 'REDIS_PORT' ];
$redisKeyStore = 'message';
$redisMessageStore = 'Hello, Redis!';
$redisExpireSec = 5;

$dataSet[Redis::class] =
    new StorageDTO(
        $redisHost,
        $redisPort,
        $redisKeyStore,
        $redisMessageStore,
        $redisExpireSec
    );

$memcacheHost = $_ENV[ 'MEMCACHED_HOST' ];
$memcachePort = $_ENV[ 'MEMCACHED_PORT' ];
$memcacheKeyStore = 'mkey';
$memcacheMessageStore = static fn(): string => 'messaged_at ' . date('G:i:s');
$memcacheExpireSec = 5;

$dataSet[Memcache::class] =
    new StorageDTO(
        $memcacheHost,
        $memcachePort,
        $memcacheKeyStore,
        $memcacheMessageStore(),
        $memcacheExpireSec
    );


/** @var StorageDTO $storage */
foreach ($dataSet as $type => $storage) {
    $memoryStorage = FabricCaching::build($type);
    $memoryStorage->connect($storage->getHost(), $storage->getPort());

    $gotValue = $memoryStorage->get($storage->getKeyStore());
    if (!$gotValue) {
        echo $EOL;
        echo printHintWithUnderscoreAndEndingMessage('Next step - set value to ', $type, '-storage.');
        echo $EOL;
        $memoryStorage->set($storage->getKeyStore(), $storage->getMessageStore(), $storage->getExpireSec());
    }
    echo $EOL;
    echo printHintAndBoldMessage(
        printHintWithUnderscoreAndEndingMessage(
            'The value from ',
            $type,
            '-storage:'
        ),
        ($gotValue ?: '[empty]')
    );
    echo $EOL;

    $memoryStorage->disconnect();
}
// -- --
echo $EOL;
echo printHintAndBoldMessage('Version_PHP: ', PHP_VERSION_ID);
echo $EOL;
// -- --
$driver = $_ENV[ 'DRIVER_DB' ];
echo printHintAndBoldMessage('DataBaseDriver: ', $driver);
echo $EOL;
echo $EOL;
// -- --
function printHintAndBoldMessage(string $hint, string $message): string
{
    return $hint . '<b>' . $message . '</b>';
}

function printHintWithUnderscoreAndEndingMessage(string $hint, string $italicMessage, string $ending): string
{
    return $hint . '<u>' . $italicMessage . '</u>' . $ending;
}
// -- --
$pgHost = $_ENV[ 'PGSQL_HOST' ];
$pgPort = $_ENV[ 'PGSQL_PORT' ];
$pgDB = $_ENV[ 'PGSQL_DB' ];
$pgUser = $_ENV[ 'PGSQL_USER' ];
$pgPassword = $_ENV[ 'PGSQL_PSW' ];
$dbSet[ 'pgsql' ] = new DBStorageDTO('pgsql', $pgHost, $pgPort, $pgDB, $pgUser, $pgPassword);

$mysqlHost = $_ENV[ 'MYSQL_HOST' ];
$mysqlPort = $_ENV[ 'MYSQL_PORT' ];
$mysqlDB = $_ENV[ 'MYSQL_DB' ];
$mysqlUser = $_ENV[ 'MYSQL_USER' ];
$mysqlPassword = $_ENV[ 'MYSQL_PSW' ];
$dbSet['mysql'] = new DBStorageDTO('mysql', $mysqlHost, $mysqlPort, $mysqlDB, $mysqlUser, $mysqlPassword);


$storageDPO = $dbSet[$driver];

$database = new Connection($storageDPO->getDsn(), $storageDPO->getUser(), $storageDPO->getPassword());
$database->query('SELECT VERSION()')->dump();
$database->disconnect();
