<?php

declare(strict_types=1);

namespace Vp\App\Application\Handler;

use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Contract\OutputInterface;
use Vp\App\Application\Handler\Contract\ConsoleHandlerInterface;
use Vp\App\Application\UseCase\Contract\StatementGeneratorInterface;

class BankStatementConsoleHandler implements ConsoleHandlerInterface
{
    private StatementGeneratorInterface $generator;
    private OutputInterface $output;

    public function __construct(StatementGeneratorInterface $generator, OutputInterface $output)
    {
        $this->generator = $generator;
        $this->output = $output;
    }
    public function handle(AMQPMessage $message): void
    {
        [$dateStart, $dateEnd] = $this->getPeriod($message);

        $statement = $this->generator->generate($dateStart, $dateEnd);
        $this->output->show($statement);
    }

    private function getPeriod(AMQPMessage $message): array
    {
        $message = json_decode($message->getBody(), true);
        $dateStart = $message['dateStart'];
        $dateEnd = $message['dateEnd'];
        return [$dateStart, $dateEnd];
    }
}
