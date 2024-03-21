<?php

require __DIR__ . '/../vendor/autoload.php';

use Telegram\Bot\Api;
use PHPMailer\PHPMailer\PHPMailer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Initialize PHPMailer
$mail = new PHPMailer(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'palm6991@gmail.com';                     //SMTP username
$mail->Password   = 'dkwg yyau quvc ldek';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;                                    //TCP port to connect to; use

// Initialize RabbitMQ connection
$rabbitmq = new AMQPStreamConnection(
    'rabbit-mq', // Hostname as defined in Docker Compose
    5672,        // Port for AMQP protocol
    'user',      // Default user from RABBITMQ_DEFAULT_USER
    'password'   // Default password from RABBITMQ_DEFAULT_PASS
);
$queuePublisher = new \Rabbit\Daniel\Queue\QueuePublisher($rabbitmq);

$channel = $rabbitmq->channel();
$channel->queue_declare('queue_name', false, true, false, false);
$chat_id = '350843460';
$email = 'palm6991@gmail.com';
// Your database connection
$db = new \PDO('pgsql:host=postgres;dbname=your_db', 'your_username', 'your_password');
$requestHandler = new \Rabbit\Daniel\Request\RequestHandler($db, $queuePublisher);
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming form data is sent with a specific structure
    $requestData = [
        'startDate' => $_POST['startDate'],
        'endDate' => $_POST['endDate'],
        'notificationMethod' => $_POST['notificationMethod'],
    ];

    // Determine the notification method based on the request and instantiate the appropriate notifier
    if ($requestData['notificationMethod'] == 'email') {
        $notifier = new \Rabbit\Daniel\Notification\EmailNotification($mail, $requestData);
    } elseif ($requestData['notificationMethod'] == 'telegram') {
        $telegram = new Api('6728633417:AAFwSVSsaG9RZCEPiy5EREQSvZI1pg-QO0M');
        $notifier = new \Rabbit\Daniel\Notification\TelegramNotification($telegram, $chat_id);
        $requestData['chat_id'] = $chat_id;
    } else {
        // Default or error handling if the method is not supported
        throw new Exception("Unsupported notification method: " . $requestData['notificationMethod']);
    }

    // Process the request
    $response = $requestHandler->handle($requestData, $notifier);

    echo $response;
}