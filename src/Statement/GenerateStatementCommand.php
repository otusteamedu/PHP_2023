<?php

declare(strict_types=1);

namespace App\Statement;

use App\RabbitMQ\Messenger;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'bank:statement:generate',
    description: 'Generates bank statement',
    aliases: ['statement:generate'],
    hidden: false
)]
final class GenerateStatementCommand extends Command
{
    public function __construct(
        private readonly Messenger $messenger,
        private readonly SerializerInterface $serializer,
        private readonly EventDispatcherInterface $eventDispatcher,

    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $processMessage = function (string $messageBody) use ($output): void {
            $statementMessage = $this->decodeMessage($messageBody);

            $output->writeln([
                'Statement generator',
                '============',
                sprintf(
                    "<info>Generated bank statement for the date from %s to %s</info>",
                    $statementMessage->getDateFrom()->format('d.m.Y H:i'),
                    $statementMessage->getDateTo()->format('d.m.Y H:i')
                )
            ]);

            $this->eventDispatcher->dispatch(new StatementIsGeneratedEvent());
        };

        $this->messenger->consume($processMessage(...));

        return Command::SUCCESS;
    }

    private function decodeMessage(string $messageBody): StatementMessage
    {
        return $this->serializer->deserialize($messageBody, StatementMessage::class, JsonEncoder::FORMAT);
    }
}
