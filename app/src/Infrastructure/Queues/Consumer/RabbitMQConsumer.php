<?php

declare(strict_types=1);

namespace App\Infrastructure\Queues\Consumer;

use App\Domain\Entity\Status;
use App\Domain\Repository\ApplicationFormRepositoryInterface;
use App\Domain\Repository\StatusRepositoryInterface;
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
    private ApplicationFormRepositoryInterface $repositoryApplicationForm;
    private StatusRepositoryInterface $repositoryStatus;

    /**
     * @throws Exception
     */
    public function __construct(
        ApplicationFormRepositoryInterface $repositoryApplicationForm,
        StatusRepositoryInterface $repositoryStatus
    ) {
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
