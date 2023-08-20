<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\BookSearchDto;
use App\Service\BookShopServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'book-search',
    description: 'Search books from otus-shop',
)]
final class BooksSearchCommand extends Command
{
    private const ALL_CHOICES = 'Все';
    private const AVAILABILITY_NOT_IMPORTANT_CHOICE = 'Наличие не важно';

    public function __construct(private readonly BookShopServiceInterface $bookShopService, string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $searchDto = $this->generateSearchInputDto($input, $output, $io);

        $page = 1;
        $pageInput = null;
        do {
            if ($pageInput === '') {
                $page++;
                $searchDto->increaseFrom($searchDto->size);
            } elseif ($pageInput !== null) {
                $page = (int)$pageInput;
                $searchDto->setFrom($page * $searchDto->size - $searchDto->size);
            }

            $searchResult = $this->bookShopService->search($searchDto);
            $total = $searchResult->total;
            $totalPages = ceil($total / $searchDto->size);
            if ($page > $totalPages) {
                break;
            }
            if ($page < 1) {
                $io->error("Не существует страницы $page");
            }

            $bookList = [];

            foreach ($searchResult->books as $book) {
                $stockList = [];
                foreach ($book->getStock() as $shop => $count) {
                    $stockList[] = "$shop: $count";
                }
                $bookList[] = [$book->getTitle(), $book->getSku(), $book->getPrice(), implode("\n", $stockList)];
            }

            $table = new Table($output);
            $table->setHeaderTitle('Книги');
            $table->setHeaders(
                ['Название', 'Артикул', 'Цена', 'Наличие']
            );
            $table->addRows($bookList);
            $table->setFooterTitle("Страница $page/$totalPages");
            $table->render();
        } while (
            ($pageInput = $io->ask('Номер страницы (Enter - следующая)', '')) === '' ||
            preg_match('/^\d+$/', $pageInput)
        );

        return Command::SUCCESS;
    }

    private function generateSearchInputDto(
        InputInterface $input,
        OutputInterface $output,
        SymfonyStyle $io
    ): BookSearchDto {
        $size = (int)$io->ask(
            question: 'Укажите количество выводимых результатов (20 по умолчанию):',
            default: '20',
            validator: static function (?string $answer) use ($io) {
                if (!preg_match('/^\d+$/', $answer)) {
                    $io->error('Некорректный ввод количества');
                }
                return $answer;
            },
        );

        $sku = $io->ask('Укажите артикул книги (enter чтобы пропустить):');
        if ($sku !== null) {
            return new BookSearchDto(size: $size, sku: $sku);
        }

        $categories = $this->askForCategories(
            $this->bookShopService->getAvailableCategories(),
            $input,
            $output
        );

        $shops = $this->askForShops(
            $this->bookShopService->getAvailableShops(),
            $input,
            $output
        );

        $minPrice = $io->ask(
            question: 'Укажите минимальную цену (в копейках):',
            validator: static function (?string $answer) use ($io) {
                if ($answer === null) {
                    return null;
                }
                if (!preg_match('/^\d+$/', $answer)) {
                    $io->error('Некорректный ввод цены');
                }
                return (int)$answer;
            },
        );
        $maxPrice = $io->ask(
            question: 'Укажите максимальную цену (в копейках):',
            validator: static function (?string $answer) use ($io) {
                if ($answer === null) {
                    return null;
                }
                if (!preg_match('/^\d+$/', $answer)) {
                    $io->error('Некорректный ввод цены');
                }
                return (int)$answer;
            },
        );

        $title = $io->ask(
            'Введите название книги:',
        );

        return new BookSearchDto(
            size: $size,
            title: $title,
            minPrice: $minPrice,
            maxPrice: $maxPrice,
            categories: $categories,
            shops: $shops,
        );
    }

    /**
     * @param string[] $availableCategories
     * @return string[]|null
     */
    private function askForCategories(
        array $availableCategories,
        InputInterface $input,
        OutputInterface $output
    ): ?array {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Укажите категории книг для поиска через запятую (все категории по умолчанию):',
            [self::ALL_CHOICES, ...$availableCategories],
            0
        );
        $question->setErrorMessage('Категория %s не существует.');
        $question->setMultiselect(true);

        /** @var string[] $categories */
        $categories = $helper->ask($input, $output, $question);
        if (in_array(self::ALL_CHOICES, $categories)) {
            return null;
        }

        return $categories;
    }

    /**
     * @param string[] $availableShops
     * @return string[]|null
     */
    private function askForShops(array $availableShops, InputInterface $input, OutputInterface $output): ?array
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Укажите магазины с книгами в наличии через запятую:',
            [self::AVAILABILITY_NOT_IMPORTANT_CHOICE, self::ALL_CHOICES, ...$availableShops],
            0
        );
        $question->setErrorMessage('Магазина %s не существует.');
        $question->setMultiselect(true);

        /** @var string[] $shops */
        $shops = $helper->ask($input, $output, $question);

        if (in_array(self::AVAILABILITY_NOT_IMPORTANT_CHOICE, $shops)) {
            return null;
        }
        if (in_array(self::ALL_CHOICES, $shops)) {
            return $availableShops;
        }

        return $shops;
    }
}
