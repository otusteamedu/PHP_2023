<?php

namespace Ad\Infrastructure\Repository;

use Ad\Domain\Ad;
use Doctrine\ORM\EntityRepository;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[] findAll()
 * @method Ad[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends EntityRepository
{
}
