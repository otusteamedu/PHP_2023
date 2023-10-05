<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\User;

use App\Application\UseCase\User\Create\CreateUser;
use App\Domain\Exception\Error;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:user:create')]
final class CreateUserCommand extends Command
{
    public function __construct(
        private readonly CreateUser $createUser,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user = $this->createUser->handle(new ConsoleCreateUserInput(
            $this->askEmail($io),
            $this->askPassword($io),
        ));
        $io->success(sprintf('User "%s" created.', $user->getId()));

        return self::SUCCESS;
    }

    public function askEmail(SymfonyStyle $io): Email
    {
        $question = new Question('Provide a email: ');

        do {
            try {
                return new Email((string) $io->askQuestion($question));
            } catch (Error $error) {
                $io->error($error->getMessage());
            }
        } while (true);
    }

    public function askPassword(SymfonyStyle $io): NotEmptyString
    {
        $question = new Question('Provide a password: ');

        do {
            try {
                return new NotEmptyString((string) $io->askQuestion($question));
            } catch (Error $error) {
                $io->error($error->getMessage());
            }
        } while (true);
    }
}
