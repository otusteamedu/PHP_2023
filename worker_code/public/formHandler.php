<?php

include '/data/mysite.local/vendor/autoload.php';

use VKorabelnikov\Hw6\SocketChat\Application;

error_reporting(E_ALL);

/////////////////////////////////


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new AMQPStreamConnection('rabbit-mq', 5672, 'user', 'password');
$channel = $connection->channel();

/*

REQUEST params:
- accountId
- dateStart
- dateEnd
- email


massage structure
- string type
- JSON format
    - fields list
        - accountId
        - dateStart
        - dateEnd
        - clientEmail


{
    "accountNumber": "100000/2345341",
    "dateStart": "2023.05.15",
    "dateEnd": "2023.07.03",
    "email": "user@email.com"
}

*/


$queueName = 'account_statement';
$channel->queue_declare($queueName, false, true, false, false);

$messageParams = [
    "accountNumber" => $_POST["accountNumber"],
    "dateStart" => $_POST["dateStart"],
    "dateEnd" => $_POST["dateEnd"],
    "email" => $_POST["email"]
];
$msg = new AMQPMessage(
    json_encode($messageParams, JSON_UNESCAPED_UNICODE),
    [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ]
);
$channel->basic_publish($msg, '', $queueName);

$channel->close();
$connection->close();

echo "Ваш запрос успешно принят.";
