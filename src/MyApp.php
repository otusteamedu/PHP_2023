<?php

namespace Iosh\PhpProf;

use Iosh\WeatherOtusTest\Weather;

class MyApp
{
    private Weather $weather;

    public function __construct($apiKey)
    {
        $this->weather = new Weather($apiKey);
    }

    public function run(): string
    {
        try {
            return $this->weather->getWeather(33, -99);
        } catch (\Exception $e) {
            return 'Ошибка';
        }
    }
}
