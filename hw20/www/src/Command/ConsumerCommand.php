<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Command;

use Doctrine\ORM\EntityManager;
use Shabanov\Otusphp\Connect\ConnectInterface;
use Shabanov\Otusphp\Messaging\Consumer\RabbitMqConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends Command
{
    private EntityManager $entityManager;
    public function __construct(private readonly ConnectInterface $connect)
    {
        global $entityManager;
        parent::__construct();
        require_once __DIR__ . '/../../config/bootstrap.php';
        $this->entityManager = $entityManager;
    }
    protected function configure(): void
    {
        $this->setName('rabbitmq:consumer')
            ->setDescription('Запуск коньсюмера обработки создания лида');
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        (new RabbitMqConsumer($this->connect, $this->entityManager))->run();

        return Command::SUCCESS;
    }
}
