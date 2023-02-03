<?php

use App\Components\DataBase;
use App\Components\DotEnv;
use App\Components\Redis;
use App\Components\Session;

require "../vendor/autoload.php";

$session = new Session();
$env = new DotEnv(sprintf('%s/.env', dirname(__DIR__)));
$redis = new Redis($env->get('REDIS_SCHEME'), $env->get('REDIS_HOST'), $env->get('REDIS_PORT'));
$db = new DataBase(
    $env->get('DB_HOST'),
    $env->get('DB_PORT'),
    $env->get('DB_NAME'),
    $env->get('DB_USER'),
    $env->get('DB_PASSWORD'),
);

$session->setIfNull('uid', uniqid());
$uid = $session->get('uid');

$visitsCountKey = sprintf('%s_visits_count', $uid);
$visitsCount = $redis->get($visitsCountKey) ?? 0;
$visitsCount++;
$redis->set($visitsCountKey, $visitsCount);

$firstVisitKey = sprintf('%s_first_visit', $uid);
$firstVisit = $redis->get($firstVisitKey);

if (null === $firstVisit) {
    $firstVisit = $db->fetchQuery('SELECT NOW() AS now;')['now'];
    $redis->set($firstVisitKey, $firstVisit);
}

$firstVisitDateTime = new DateTimeImmutable($firstVisit);

echo sprintf('<h1>Привет, %s!</h1>', $uid);
echo sprintf(
    '<p>Первый раз вы посетили страницу %s в %s.</p>',
    $firstVisitDateTime->format('d M Y'),
    $firstVisitDateTime->format('H:i:s'),
);
echo sprintf('<p>Номер визита: %d.</p>', $visitsCount);
