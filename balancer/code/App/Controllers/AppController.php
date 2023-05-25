<?php

namespace IilyukDmitryi\App\Controllers;

use IilyukDmitryi\App\Statistic\StatisticEngine;
use IilyukDmitryi\App\Validation\Bracket;
use IilyukDmitryi\App\Validation\Validation;

class AppController
{
    /**
     * @var Validation[] $checkers
     */
    private array $checkers;
    private ?StatisticEngine $statisticEngine;
    private string $stringCheck = '';

    /**
     * @param StatisticEngine $statisticEngine
     */
    public function setStatisticEngine(StatisticEngine $statisticEngine): void
    {
        $this->statisticEngine = $statisticEngine;
    }

    public function checkStringPost(): void
    {
        if (!$this->isPost()) {
            $this->processCheckFail();
            return;
        }
        $this->stringCheck = $this->getStringPostCheck();
        $resultChecking = $this->getResultChecking();

        if ($resultChecking) {
            $this->processCheckSuccess();
        } else {
            $this->processCheckFail();
        }
        $this->printStatisticResult();
    }

    private function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    private function processCheckFail(): void
    {
        echo "<h2 style='color: red;text-align: center;'>stroke  " . $this->stringCheck . " is  ##FAIL## </h2>";

        http_response_code(400);
        $this->addStatisticResult(400);
    }

    private function addStatisticResult(int $code): void
    {
        $str = $this->stringCheck;
        if (empty($str)) {
            $str = '*empty*';
        }
        if (!is_null($this->statisticEngine)) {
            $this->statisticEngine->addStat($code === 200 ? true : false, $str);
        }
    }

    private function getStringPostCheck(): string
    {
        if (isset($_POST['string'])) {
            $str = $_POST['string'];
            if (!empty($str) && is_string($str)) {
                return htmlspecialchars($str);
            }
        }
        return '';
    }

    private function getResultChecking(): bool
    {
        $str = $this->stringCheck;
        $this->makeCheckers();
        foreach ($this->checkers as $checker) {
            if ($checker->check($str) === false) {
                return false;
            }
        }
        return true;
    }

    private function makeCheckers(): void
    {
        $this->checkers[] = new Bracket();
    }

    private function processCheckSuccess(): void
    {
        echo "<h2 style='color: green;text-align: center;'>stroke " . $this->stringCheck . " is **GOOD** </h2>";
        http_response_code(200);
        $this->addStatisticResult(200);
    }

    private function printStatisticResult(): void
    {
        if (!is_null($this->statisticEngine)) {
            $this->statisticEngine->printStat();
        }
    }
}
