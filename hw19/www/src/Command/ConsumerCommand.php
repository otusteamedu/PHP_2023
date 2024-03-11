<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Command;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use Shabanov\Otusphp\Connection\ConnectionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends Command
{
    private string $connectClient = 'Shabanov\Otusphp\Connection\RabbitMqConnect';
    private string $queue = 'otus';
    private AMQPChannel|AbstractChannel $channel;
    private ConnectionInterface $connect;

    protected function configure(): void
    {
        $this->setName('rabbitmq:consumer')
            ->setDescription('RabbitMQ consumer обработчик формы');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->connect = new $this->connectClient();
        $this->channel = $this->connect->getClient();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $callback = function ($msg) use ($output) {
            /**
             * Выведим в консоль поступившую строку
             */
            $output->writeln('<info>[x] ' . $msg->body . '</info>');
            /**
             * Отправим строку на Email
             */
            $this->sendEmail($msg->body);
        };

        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connect->close();

        return Command::SUCCESS;
    }

    protected function sendEmail(string $body): void
    {
        $mail = new \PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.yandex.ru';
            $mail->SMTPAuth = true;
            $mail->Username = 'saveliy';
            $mail->Password = 'password';
            $mail->Port = 465;

            $mail->setFrom('sender@yandex.ru', 'Sender');
            $mail->addAddress('recipient@yandex.ru', 'Recipient');

            $mail->Subject = 'Новое сообщение';
            $mail->Body = $body;

            $mail->send();
        } catch (Exception $e) {
            echo 'Ошибка отправки письма: ' . $mail->ErrorInfo;
        }
    }
}
