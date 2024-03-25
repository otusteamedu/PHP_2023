<?php

namespace Rabbit\Daniel;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Rabbit\Daniel\Notification\EmailNotification;
use Rabbit\Daniel\Notification\TelegramNotification;
use Rabbit\Daniel\Request\RequestHandler;
use Telegram\Bot\Api;

class App
{
    private $rabbitMQConnection;
    private $requestHandler;

    public function __construct()
    {
        $this->setUpRabbitMQConnection();
        $this->setUpRequestHandler();
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
                $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
                $mailer->isSMTP();
                $mailer->Host = SMTP_HOST;
                $mailer->SMTPAuth = true;
                $mailer->Username = SMTP_USER;
                $mailer->Password = SMTP_PASSWORD;
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
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