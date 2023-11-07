<?php

declare(strict_types=1);

namespace Gesparo\HW;

use Gesparo\HW\Mapper\FilmMapper;
use Gesparo\HW\Mapper\ScreeningMapper;
use Gesparo\HW\Service\DemonstrationService;

class App
{
    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function run(string $rootPath): void
    {
        $this->initPathHelper($rootPath);
        $envManager = $this->getEnvManager(PathHelper::getInstance()->getEnvPath());
        $pdo = $this->getPdo($envManager);
        $outputHelper = $this->getOutputHelper();
        $screeningMapper = $this->getScreeningMapper($pdo);
        $filmMapper = $this->getFilmMapper($pdo, $screeningMapper);

        (new DemonstrationService($filmMapper, $screeningMapper, $outputHelper))->run();
    }

    private function initPathHelper(string $rootPath): void
    {
        PathHelper::initInstance($rootPath);
    }

    private function getEnvManager(string $pathToEnvFile): EnvManager
    {
        return (new EnvCreator($pathToEnvFile))->create();
    }

    private function getPdo(EnvManager $envManager): \PDO
    {
        return (new \PDO(
            "mysql:dbname={$envManager->getMysqlDatabase()};host=mysql",
            $envManager->getMysqlUser(),
            $envManager->getMysqlPassword())
        );
    }

    private function getOutputHelper(): OutputHelper
    {
        return new OutputHelper();
    }

    private function getScreeningMapper(\PDO $pdo): ScreeningMapper
    {
        return new ScreeningMapper($pdo);
    }

    private function getFilmMapper(\PDO $pdo, ScreeningMapper $screeningMapper): FilmMapper
    {
        return new FilmMapper($pdo, $screeningMapper);
    }
}
