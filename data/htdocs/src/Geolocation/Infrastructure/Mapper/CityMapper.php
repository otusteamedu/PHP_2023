<?php

namespace Geolocation\Infrastructure\Mapper;

use Geolocation\App\CityIdentityMap;
use Geolocation\Domain\City;
use Geolocation\Infrastructure\CityFactory;

class CityMapper implements \Geolocation\Domain\CityRepositoryInterface
{
    public function __construct(private readonly \PDO $db, private readonly CityIdentityMap $identityMap)
    {
    }

    public function getById(int $id): City
    {
        if ($this->identityMap->has($id)) {
            return $this->identityMap->get($id);
        }

        $stmt = $this->db->prepare('SELECT * FROM city WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $arCity = $stmt->fetch(\PDO::FETCH_ASSOC);
        $city = (new CityFactory())->fromDb($arCity);
        $this->identityMap->set($id, $city);
        return $city;
    }

    public function getByName(string $name): City
    {
        $stmt = $this->db->prepare('SELECT * FROM city WHERE name = :name');
        $stmt->execute(['name' => $name]);
        $city = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$city) {
            throw new \Exception('City not found');
        }

        $city = (new CityFactory())->fromDb($city);

        $this->identityMap->set($city->getId(), $city);
        return $city;
    }

    public function add(City $city): void
    {
        $stmt = $this->db->prepare('INSERT INTO city (name, latitude, longitude, created_at, updated_at) VALUES (:name, :latitude, :longitude, :created_at, :updated_at)');
        $stmt->execute(
            [
                'name' => $city->getName(),
                'latitude' => $city->getLatitude(),
                'longitude' => $city->getLongitude(),
            ]
        );
        $city->setId((int)$this->db->lastInsertId());
        $this->identityMap->set($city->getId(), $city);
    }

    public function update(City $city): void
    {
        if (empty($city->getChangedFields())) {
            return;
        }

        $flds = array_map(
            function ($fld) {
                return $fld . ' = :' . $fld;
            },
            $city->getChangedFields()
        );

        $data = [
            'name' => $city->getName(),
            'latitude' => $city->getLatitude(),
            'longitude' => $city->getLongitude()
        ];

        foreach ($data as $key => $value) {
            if (!in_array($key, $city->getChangedFields())) {
                unset($data[$key]);
            }
        }

        $stmt = $this->db->prepare('UPDATE city SET ' . implode(', ', $flds) . ' WHERE id = :id');

        $stmt->execute(
            $data + [
                'id' => $city->getId()
            ]
        );
        $this->identityMap->set($city->getId(), $city);
    }

    public function delete(City $city): void
    {
        $stmt = $this->db->prepare('DELETE FROM city WHERE id = :id');
        $stmt->execute(['id' => $city->getId()]);
        $this->identityMap->remove($city->getId());
    }

    public function getAll(): \Generator
    {
        $stmt = $this->db->prepare('SELECT * FROM city');
        $stmt->execute();

        $cities = [];
        while ($city = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->identityMap->set($city['id'], $city);
            yield (new CityFactory())->fromDb($city);
        }
    }
}
