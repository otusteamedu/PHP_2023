<?php

require __DIR__ . '/../vendor/autoload.php';

use Telegram\Bot\Api;
use PHPMailer\PHPMailer\PHPMailer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Initialize Telegram Bot API with your bot's token
$telegram = new Api('6728633417:AAFwSVSsaG9RZCEPiy5EREQSvZI1pg-QO0M');

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
$channel = $rabbitmq->channel();
$channel->queue_declare('queue_name', false, true, false, false);
$chat_id = '350843460';
$email = 'palm6991@gmail.com';
// Your database connection
$db = new \PDO('pgsql:host=postgres;dbname=your_db', 'your_username', 'your_password');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $notificationMethod = $_POST['notificationMethod'];

    // Insert into the database (ensure you have the right SQL according to your table structure)
    $stmt = $db->prepare("INSERT INTO Requests (start_date, end_date, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$startDate, $endDate]);
    $requestId = $db->lastInsertId();

    // Determine the notification method and send the message
    if ($notificationMethod == 'email') {
        // Send an email
        try {
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($email); // Add a recipient
            $mail->isHTML(true);
            $mail->Subject = 'Your request is being processed';
            $mail->Body    = 'We are processing your request for a bank statement from '.$startDate.' to '.$endDate;

            $mail->send();
        } catch (Exception $e) {
            // Handle the error
            error_log("Mailer Error: {$mail->ErrorInfo}");
        }
    } elseif ($notificationMethod == 'telegram') {
        // Send a Telegram message
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Your request is being processed'
        ]);
    }

    // Push a message to the RabbitMQ queue
    $msg = new AMQPMessage(json_encode([
        'requestId' => $requestId,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'chat_id' => $chat_id,
        'notification_method' => $notificationMethod,
        'email' => $email
    ]));
    $channel->basic_publish($msg, '', 'queue_name');

    // Properly close the channel and the connection
    $channel->close();
    $rabbitmq->close();

    // Redirect or inform the user of successful submission
    echo "Request received and notification sent.";
}