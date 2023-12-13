<?php

namespace App\Infrastructure\Queues\Consumer;

use App\Domain\Entity\Status;
use App\Domain\Repository\ApplicationFormInterface;
use App\Domain\Repository\StatusInterface;
use App\Domain\ValueObject\Name;
use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Exception;
use React\Promise\PromiseInterface;

class RabbitMQConsumer implements ConsumerInterface
{
    private Client $client;
    private string $queue;
    private PromiseInterface|Channel $channel;
    private ApplicationFormInterface $repositoryApplicationForm;
    private StatusInterface $repositoryStatus;

    /**
     * @throws Exception
     */
    public function __construct(ApplicationFormInterface $repositoryApplicationForm, StatusInterface $repositoryStatus)
    {
        $this->repositoryApplicationForm = $repositoryApplicationForm;
        $this->repositoryStatus = $repositoryStatus;
        $this->client = new Client([
            'host'      => 'rabbitmq',
            'vhost'     => '/',
            'user'      => $_ENV['RABBITMQ_DEFAULT_USER'],
            'password'  => $_ENV['RABBITMQ_DEFAULT_PASS'],
        ]);
        $this->queue = $_ENV['QUEUE'];

        $this->client->connect();
        $this->channel = $this->client->channel();

        $this->channel->qos(prefetchCount: 1);

        $this->consume();
    }

    private function consume(): void
    {
        $this->channel->consume(function (Message $message, Channel $channel): void {
            sleep(30);

            $id = json_decode($message->content, true)['id'];
            $applicationForm = $this->repositoryApplicationForm->findOneById($id);
            $status = $this->repositoryStatus->findByName(new Name(Status::DONE));
            $applicationForm->setStatus($status);
            $this->repositoryApplicationForm->save($applicationForm);

            $channel->ack($message);
        }, $this->queue);
    }

    public function run(): void
    {
        $this->client->run();
    }
}
