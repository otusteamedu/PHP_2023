<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Category;

use App\Application\UseCase\Category\Create\CreateCategory;
use App\Domain\Exception\Error;
use App\Domain\ValueObject\NotEmptyString;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:category:create')]
final class CreateCategoryCommand extends Command
{
    public function __construct(
        private readonly CreateCategory $createCategory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $category = $this->createCategory->handle(new ConsoleCreateCategoryInput(
            $this->askName($io),
        ));
        $io->success(sprintf('Category "%s" created.', $category->getId()));

        return self::SUCCESS;
    }

    public function askName(SymfonyStyle $io): NotEmptyString
    {
        $question = new Question('Provide a category name: ');

        do {
            try {
                return new NotEmptyString((string) $io->askQuestion($question));
            } catch (Error $error) {
                $io->error($error->getMessage());
            }
        } while (true);
    }
}
