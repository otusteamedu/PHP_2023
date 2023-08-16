<?php

namespace App\Command;

use App\Service\EmailChecker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputArgument, InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

#[AsCommand(
    name: 'app:check-email',
    description: 'check email',
)]
class CheckEmailCommand extends Command
{
    private EmailChecker $emailChecker;

    public function __construct(EmailChecker $emailChecker)
    {
        parent::__construct();
        $this->emailChecker = $emailChecker;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to check emails')
            ->addArgument('email', InputArgument::OPTIONAL, 'email to check')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'File with emails');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $filepath = $input->getOption('file');

        if (!$email && !$filepath) {
            $io->note('You should specify single email or email file (option "file")');
            return Command::INVALID;
        }

        if ($email) {
            if (!$this->emailChecker->isEmailValid((string)$email)) {
                $io->caution(EmailChecker::NOT_VALID_EMAIL_MESSAGE);
                return Command::SUCCESS;
            }

            $io->success('OK');
            return Command::SUCCESS;
        }

        if ($filepath) {
            try {
                $file = new File($filepath);
            } catch (FileNotFoundException $e) {
                $io->error($e->getMessage());
                return Command::INVALID;
            }

            $checkResult = $this->emailChecker->checkEmailWithFile($file);
            $io->writeln('success - ' . count($checkResult->getValidEmail()));
            $io->writeln('failure - ' . count($checkResult->getInvalidEmail()));

            return Command::SUCCESS;
        }

        return Command::INVALID;
    }
}
