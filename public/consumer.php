<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Telegram\Bot\Api;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$pdo = new \PDO('pgsql:host=postgres;dbname=your_db', 'your_username', 'your_password');


$connection = new AMQPStreamConnection(
    'rabbit-mq', // Hostname as defined in Docker Compose
    5672,        // Port for AMQP protocol
    'user',      // Default user from RABBITMQ_DEFAULT_USER
    'password'   // Default password from RABBITMQ_DEFAULT_PASS
);
$channel = $connection->channel();

$channel->queue_declare('queue_name', false, true, false, false);

$telegram = new Api('6728633417:AAFwSVSsaG9RZCEPiy5EREQSvZI1pg-QO0M');

$callback = function($msg) use ($telegram, $pdo) {
    echo "Received message", $msg->body, "\n";
    $data = json_decode($msg->body, true);
    $chat_id = $data['chat_id'];
    $startDate = $data['startDate'];
    $endDate = $data['endDate'];

    // Query the database for transactions in the given date range
    $stmt = $pdo->prepare("SELECT * FROM Transactions WHERE transaction_date BETWEEN ? AND ?");
    $stmt->execute([$startDate, $endDate]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the transactions into a message
    $message = "Transactions from $startDate to $endDate:\n";
    foreach ($transactions as $transaction) {
        $message .= "{$transaction['description']}: {$transaction['amount']}\n";
    }

    if (isset($data['notification_method']) && $data['notification_method'] == 'email') {

        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'palm6991@gmail.com';                     //SMTP username
            $mail->Password   = 'dkwg yyau quvc ldek';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('palm6991@gmail.com', 'Mailer');
            $mail->addAddress($data['email']); // Add a recipient, using email from the data

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Transaction Report';
            $mail->Body = $message; // Your message content

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Send a message to the Telegram chat as before
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $message
        ]);
    }
};

$channel->basic_consume('queue_name', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();