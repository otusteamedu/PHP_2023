<?php
declare(strict_types=1);

namespace WorkingCode\Hw13\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WorkingCode\Hw13\Entity\Film;
use WorkingCode\Hw13\Repository\FilmRepository;

class DemoCommand extends Command
{
    public function __construct(private readonly FilmRepository $filmRepository)
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $film1 = (new Film())
            ->setName('Три богатыря')
            ->setDescription('По сказкам мы знаем, что было давным-давно,...');
        $film2 = (new Film())
            ->setName('XXX')
            ->setDescription('описание фильма XXX');
        $film3 = (new Film())
            ->setName('XXX 2')
            ->setDescription('описание фильма XXX 2');
        $this->filmRepository->save($film1);
        $this->filmRepository->save($film2);
        $this->filmRepository->save($film3);

        $films = $this->filmRepository->getAll();
        $output->writeln(print_r($films->toArray(), true));
        $output->writeln("Количество записей: " . $films->count());

        return static::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setName('demo:start')
            ->setDescription('start demonstration application');
    }
}
