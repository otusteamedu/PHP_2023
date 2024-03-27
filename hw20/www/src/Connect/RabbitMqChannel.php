<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Connect;

use Doctrine\ORM\EntityManager;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Shabanov\Otusphp\Entity\Lead;
use Shabanov\Otusphp\Repository\LeadRepository;

readonly class RabbitMqChannel implements ChannelInterface
{
    private string $exchange;
    private readonly EntityManager $entityManager;
    public function __construct(private AMQPChannel $channel)
    {}
    public function setQueue(string $queue): self
    {
        $this->channel->queue_declare($queue, false, false, false, false);
        return $this;
    }

    public function setExchange(string $exchange): self
    {
        $this->exchange = $exchange;
        $this->channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
        return $this;
    }

    public function bindQueue(string $queue, string $exchange): self
    {
        $this->channel->queue_bind($queue, $exchange);
        return $this;
    }

    public function send(AMQPMessage $message): void
    {
        $this->channel->basic_publish($message, $this->exchange);
    }

    public function consume(string $queue, EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
        $this->channel->basic_consume($queue, '', false, false, false, false, [$this, 'consumeHandler']);
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function consumeHandler(AMQPMessage $message): void
    {
        $post = json_decode($message->getBody(), true);
        if (!empty($post['name']) && !empty($post['email'])) {
            /**
             * Добавим лид
             */
            $lead = (new Lead())
                ->setName($post['name'])
                ->setEmail($post['email'])
                ->setUuid($post['uuid']);
            $leadRepository = new LeadRepository($this->entityManager, Lead::class);
            $leadRepository->save($lead);

            /**
             * Подтвердим успешность в очередь
             */
            $message->getChannel()->basic_ack(
                $message->getDeliveryTag()
            );
        }
    }

    public function close(): void
    {
        $this->channel->close();
    }
}
