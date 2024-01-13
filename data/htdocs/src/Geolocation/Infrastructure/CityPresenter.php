<?php

namespace Geolocation\Infrastructure;

use Geolocation\Domain\City;

class CityPresenter
{
    public static function present(City $city): array
    {
        return [
            'id' => $city->getId(),
            'name' => $city->getName(),
            'latitude' => $city->getLatitude(),
            'longitude' => $city->getLongitude()
        ];
    }
}
