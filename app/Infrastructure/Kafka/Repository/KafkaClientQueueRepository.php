<?php

namespace App\Infrastructure\Kafka\Repository;

use App\Application\Action\Notifier\Notifier;
use App\Application\Action\Notify\EmailNotify;
use App\Application\Action\Notify\TelegramNotify;
use App\Application\Log\Log;
use App\Infrastructure\QueueRepositoryInterface;
use NdybnovHw03\CnfRead\Storage;

class KafkaClientQueueRepository implements QueueRepositoryInterface
{
    private string $uniqName;
    private Log $log;
    private Storage $cnf;

    public function __construct(
        Storage $config
    ) {
        $this->cnf = $config;
        $this->uniqName = $config->get('QUEUE_UNIQUE');

        $this->log = new Log();
        $this->log->useLogStep('Kafka connected ...');
    }

    public function __destruct()
    {
        $this->log->useLogStep('Kafka disconnected.');
    }

    public function add(string $message): void
    {
        $conn = sprintf(
            '%s:%s',
            $this->cnf->get('KAFKA_HOST'),
            $this->cnf->get('KAFKA_PORT')
        );

        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', $conn);

        $producer = new \RdKafka\Producer($conf);
        $producer->addBrokers($conn);
        $topic = $producer->newTopic($this->uniqName);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $producer->flush(1000);
    }

    public function readMessagesAndNotify(string $par = ''): void
    {
        $notifier = new Notifier($this->cnf);
        $notifier->add(EmailNotify::class);
        $notifier->add(TelegramNotify::class);

        $conn = sprintf(
            '%s:%s',
            $this->cnf->get('KAFKA_HOST'),
            $this->cnf->get('KAFKA_PORT')
        );

        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', $conn);
        $conf->set('group.id', 'test_group');

        $consumer = new \RdKafka\KafkaConsumer($conf);
        $consumer->subscribe([$this->uniqName]);

        $log = $this->log;
        $functions = [
            RD_KAFKA_RESP_ERR_NO_ERROR => function ($message) use ($notifier, $log) {
                $msgCli = sprintf(
                    'Read from Kafka message: %s',
                    $message->payload
                );
                $log->printConsole($msgCli);
                $log->printConsole(PHP_EOL);
                $log->printConsole(PHP_EOL);
                $notifier->run($message->payload);
                $log->printConsole(PHP_EOL);
            },
            RD_KAFKA_RESP_ERR__PARTITION_EOF => function ($message) {
                $this->log->printErr('No more messages; will wait for more');
            },
            RD_KAFKA_RESP_ERR__TIMED_OUT => function ($message) {
                $this->log->printErr('Timed out');
            }
        ];

        while (true) {
            $message = $consumer->consume(120 * 1000);
            if (!isset($functions[$message->err])) {
                throw new \RuntimeException($message->errstr(), $message->err);
            }
            $functions[$message->err]($message);
        }

        $consumer->close();
    }

    public function clear(): void
    {
        $conn = sprintf(
            '%s:%s',
            $this->cnf->get('KAFKA_HOST'),
            $this->cnf->get('KAFKA_PORT')
        );

        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', $conn);
        $conf->set('group.id', 'test_group');

        $consumer = new \RdKafka\KafkaConsumer($conf);
        $consumer->close();
    }
}
