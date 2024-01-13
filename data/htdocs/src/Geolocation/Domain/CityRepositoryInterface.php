<?php

namespace Geolocation\Domain;

interface CityRepositoryInterface
{
    public function getById(int $id): City;

    public function getByName(string $name): City;

    public function add(City $city): void;

    public function update(City $city): void;

    public function delete(City $city): void;

    public function getAll(): \Generator;
}
