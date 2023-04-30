<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Infrastructure\Command;

use Imitronov\Hw11\Application\UseCase\SearchProduct;
use Imitronov\Hw11\Domain\Entity\Product;
use Imitronov\Hw11\Domain\Exception\ExternalServerException;
use Imitronov\Hw11\Domain\ValueObject\Stock;
use Imitronov\Hw11\Infrastructure\Cli\CliSearchProductInput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:products:search')]
final class SearchProductsCommand extends Command
{
    public function __construct(
        private readonly SearchProduct $searchProduct,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Поиск товара по названию, категории и цене.');
        $this->addOption('title', 't', InputOption::VALUE_REQUIRED, 'Искомое название.');
        $this->addOption('category', 'c', InputOption::VALUE_OPTIONAL, 'Искомая категория.');
        $this->addOption('price', 'p', InputOption::VALUE_OPTIONAL, 'Цена.');
    }

    /**
     * @throws ExternalServerException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $searchProductInput = new CliSearchProductInput(
            $input->getOption('title'),
            $input->getOption('category'),
            $input->getOption('price'),
        );
        $products = $this->searchProduct->handle($searchProductInput);

        if (count($products) === 0) {
            $io = new SymfonyStyle($input, $output);
            $io->error('Товары не найдены.');

            return self::FAILURE;
        }

        (new Table($output))
            ->setHeaders(['SKU', 'Категория', 'Название', 'Цена', 'Остатки'])
            ->addRows(array_map(
                static fn (Product $product) => [
                    $product->getSku(),
                    $product->getCategory(),
                    $product->getName(),
                    $product->getPrice(),
                    implode(
                        PHP_EOL,
                        array_map(
                            static fn (Stock $stock) => sprintf('%s: %d', $stock->getName(), $stock->getQuantity()),
                            $product->getStock(),
                        ),
                    ),
                ],
                $products,
            ))
            ->render();

        return self::SUCCESS;
    }
}
