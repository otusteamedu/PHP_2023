<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('DB_DSN', "pgsql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

define('RABBITMQ_HOST', $_ENV['RABBITMQ_HOST']);
define('RABBITMQ_PORT', $_ENV['RABBITMQ_PORT']);
define('RABBITMQ_USER', $_ENV['RABBITMQ_USER']);
define('RABBITMQ_PASSWORD', $_ENV['RABBITMQ_PASSWORD']);

define('SMTP_HOST', $_ENV['SMTP_HOST']);
define('SMTP_USER', $_ENV['SMTP_USER']);
define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD']);
define('SMTP_PORT', $_ENV['SMTP_PORT']);

define('TELEGRAM_BOT_TOKEN', $_ENV['TELEGRAM_BOT_TOKEN']);

define('CHAT_ID', $_ENV['CHAT_ID']);

define('EMAIL', $_ENV['EMAIL']);
