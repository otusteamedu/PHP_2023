<?php

namespace Geolocation\Infrastructure;

use Geolocation\Domain\City;

class CityFactory
{
    public function fromDb(array $city): City
    {
        return new City(
            $city['id'],
            $city['name'],
            $city['latitude'],
            $city['longitude'],
            new \DateTime($city['created_at']),
            new \DateTime($city['updated_at'])
        );
    }
}
