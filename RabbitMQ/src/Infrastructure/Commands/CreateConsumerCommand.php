<?php

namespace App\Infrastructure\Commands;

use App\Application\Dto\TransactionsInfoDto;
use App\Application\UseCase\ConsumeMessageUseCase;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\Channel;
use Bunny\Message;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CreateConsumerCommand extends Command
{
    private SerializerInterface $serializer;
    public function __construct(private readonly ConsumeMessageUseCase $consumeMessageUseCase) {
        parent::__construct();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    protected function configure()
    {
        $this
            ->setName('rabbitMQ:consumer-create');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->consumeMessageUseCase->run();

        return self::SUCCESS;
    }
}
