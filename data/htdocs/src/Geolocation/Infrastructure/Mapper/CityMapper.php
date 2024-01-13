<?php

namespace Geolocation\Infrastructure\Mapper;

use Geolocation\App\CityIdentityMap;
use Geolocation\Domain\City;

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
        $city = $stmt->fetchObject(City::class);
        $this->identityMap->set($id, $city);
        return $city;
    }

    public function getByName(string $name): City
    {
        $stmt = $this->db->prepare('SELECT * FROM city WHERE name = :name');
        $stmt->execute(['name' => $name]);
        $city = $stmt->fetch(\PDO::FETCH_ASSOC);

        $city = new City(
            $city['id'],
            $city['name'],
            $city['latitude'],
            $city['longitude'],
            new \DateTime($city['created_at']),
            new \DateTime($city['updated_at'])
        );

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
                'created_at' => $city->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $city->getUpdatedAt()->format('Y-m-d H:i:s'),
            ]
        );
        $city->setId((int)$this->db->lastInsertId());
        $this->identityMap->set($city->getId(), $city);
    }

    public function update(City $city): void
    {
        $stmt = $this->db->prepare('UPDATE city SET name = :name, country_id = :country_id WHERE id = :id');
        $stmt->execute([
            'id' => $city->getId(),
            'name' => $city->getName(),
            'country_id' => $city->getCountryId(),
        ]);
        $this->identityMap->set($city->getId(), $city);
    }

    public function delete(City $city): void
    {
        $stmt = $this->db->prepare('DELETE FROM city WHERE id = :id');
        $stmt->execute(['id' => $city->getId()]);
        $this->identityMap->remove($city->getId());
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM city');
        $stmt->execute();
        $cities = $stmt->fetchAll(\PDO::FETCH_CLASS, City::class);
        $this->identityMap->setAll($cities);
        return $cities;
    }
}
