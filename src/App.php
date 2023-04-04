<?php

declare(strict_types=1);

namespace Twent\Test;

use Twent\DesignPatterns\Creational\AbstractFactory\FulltimeEmployeeFactory;
use Twent\DesignPatterns\Creational\AbstractFactory\TemporaryEmployeeFactory;

final class App
{
    public static function run(): void
    {
        $webDeveloper = FulltimeEmployeeFactory::makeWebDeveloper();
        $designer = TemporaryEmployeeFactory::makeDesigner();

        var_dump($designer->work());
        var_dump($webDeveloper->work());
    }
}
