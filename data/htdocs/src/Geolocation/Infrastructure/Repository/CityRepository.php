<?php

namespace Geolocation\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Geolocation\Domain\City;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[] findAll()
 * @method City[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class
CityRepository extends EntityRepository
{
}