<?php

namespace Rabbit\Daniel\Consumer;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Telegram\Bot\Api;

class Consumer
{
    private $pdo;
    private $connection;
    private $channel;
    private $telegram;

    public function __construct()
    {
        $this->pdo = new \PDO(DB_DSN, DB_USER, DB_PASSWORD);;
        $this->connection = new AMQPStreamConnection(
            RABBITMQ_HOST,
            RABBITMQ_PORT,
            RABBITMQ_USER,
            RABBITMQ_PASSWORD
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('queue_name', false, true, false, false);

        $this->telegram = new Api(TELEGRAM_BOT_TOKEN);
    }

    public function consume(): void
    {
        $callback = function ($msg) {
            $this->processMessage($msg);
        };

        $this->channel->basic_consume('queue_name', '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->close();
    }

    private function processMessage(AMQPMessage $msg): void
    {
        echo "Received message", $msg->body, "\n";
        $data = json_decode($msg->body, true);
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];

        $stmt = $this->pdo->prepare("SELECT * FROM Transactions WHERE transaction_date BETWEEN ? AND ?");
        $stmt->execute([$startDate, $endDate]);
        $transactions = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $message = "Transactions from $startDate to $endDate:\n";
        foreach ($transactions as $transaction) {
            $message .= "{$transaction['description']}: {$transaction['amount']}\n";
        }

        $data['message'] = $message;

        if ($data['notificationMethod'] === 'email') {
            $this->sendEmail($data);
        } else {
            $this->sendTelegramMessage($data['chat_id'], $message);
        }
    }

    private function sendEmail($data): void
    {
        $mailer = new PHPMailer(true);
        try {
            $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
            $mailer->isSMTP();
            $mailer->Host = SMTP_HOST;
            $mailer->SMTPAuth = true;
            $mailer->Username = SMTP_USER;
            $mailer->Password = SMTP_PASSWORD;
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mailer->Port = SMTP_PORT;

            $mailer->setFrom('from@example.com', 'Mailer');
            $mailer->addAddress($data['email']);

            $mailer->isHTML(true);
            $mailer->Subject = 'Your Subject Here';
            $mailer->Body = $data['message'];

            $mailer->send();
            echo 'Email has been sent';
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mailer->ErrorInfo}";
        }
    }

    private function sendTelegramMessage($chat_id, $message)
    {
        try {
            $this->telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => $message
            ]);
            echo 'Telegram message has been sent';
        } catch (Exception $e) {
            echo "Telegram message could not be sent. Error: {$e->getMessage()}";
        }
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}