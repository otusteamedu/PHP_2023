<?php

namespace Rabbit\Daniel;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Rabbit\Daniel\Database\DatabaseConnection;
use Rabbit\Daniel\Notification\EmailNotification;
use Rabbit\Daniel\Notification\TelegramNotification;
use Rabbit\Daniel\RabbitMQ\RabbitMQConnection;
use Rabbit\Daniel\Request\RequestHandler;
use Telegram\Bot\Api;

class App
{
    private $dbConnection;
    private $rabbitMQConnection;
    private $requestHandler;

    public function __construct()
    {
        $this->setUpDatabaseConnection();
        $this->setUpRabbitMQConnection();
        $this->setUpRequestHandler();
    }

    private function setUpDatabaseConnection(): void
    {
        $this->dbConnection = new DatabaseConnection(
            DB_DSN,
            DB_USER,
            DB_PASSWORD
        );
    }

    private function setUpRabbitMQConnection(): void
    {
        $this->rabbitMQConnection = new AMQPStreamConnection(
            RABBITMQ_HOST,
            RABBITMQ_PORT,
            RABBITMQ_USER,
            RABBITMQ_PASSWORD
        );
    }

    private function setUpRequestHandler(): void
    {
        $this->requestHandler = new RequestHandler();
    }

    /**
     * @throws Exception
     */
    public function handleRequest($requestData)
    {
        $notifier = $this->determineNotifier($requestData['notificationMethod']);

        $this->publishToQueue('queue_name', $requestData);

        return $this->requestHandler->handle($requestData, $notifier);
    }

    public function publishToQueue($queueName, $data): void
    {
        $channel = $this->rabbitMQConnection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        $messageBody = json_encode($data);
        $msg = new AMQPMessage($messageBody, [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $channel->basic_publish($msg, '', $queueName);

        echo "Сообщение успешно отправлено в очередь '{$queueName}'.\n";

        $channel->close();
        $this->rabbitMQConnection->close();
    }

    private function determineNotifier($method): EmailNotification|TelegramNotification
    {
        switch ($method) {
            case 'email':
                $mailer = new PHPMailer(true);
                $mailer->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
                $mailer->isSMTP();                                          // Send using SMTP
                $mailer->Host = SMTP_HOST;                                  // Set the SMTP server to send through
                $mailer->SMTPAuth = true;                                   // Enable SMTP authentication
                $mailer->Username = SMTP_USER;                              // SMTP username from constants
                $mailer->Password = SMTP_PASSWORD;                          // SMTP password from constants
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          // Enable implicit TLS encryption
                $mailer->Port = SMTP_PORT;
                return new EmailNotification($mailer);

            case 'telegram':
                $telegramApi = new Api(TELEGRAM_BOT_TOKEN);
                return new TelegramNotification($telegramApi);

            default:
                throw new Exception("Unsupported notification method: {$method}");
        }
    }
}