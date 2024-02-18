<?php
declare(strict_types=1);

namespace WorkingCode\Hw13;

use Exception;
use PDO;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Dotenv\Dotenv;
use WorkingCode\Hw13\Command\DemoCommand;
use WorkingCode\Hw13\Entity\Builder\FilmBuilder;
use WorkingCode\Hw13\Repository\FilmRepository;
use WorkingCode\Hw13\Repository\IdentityMap;

readonly class Application
{
    private FilmRepository $filmRepository;

    public function __construct()
    {
        (new Dotenv())->load('.env');

        $pdo = new PDO(sprintf(
            'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
            $_ENV['POSTGRES_HOST'],
            $_ENV['POSTGRES_PORT'],
            $_ENV['POSTGRES_DB'],
            $_ENV['POSTGRES_USER'],
            $_ENV['POSTGRES_PASSWORD'],
        ));

        $this->filmRepository = new FilmRepository($pdo, new FilmBuilder(), new IdentityMap());
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $consoleApplication = new ConsoleApplication('home work №13', '1.0');
        $consoleApplication->add(new DemoCommand($this->filmRepository));
        $consoleApplication->run();
    }
}
