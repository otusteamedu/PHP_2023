<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Shabanov\Otusphp\Entity\Lead;

/**
 * @template Lead
 */
class LeadRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, $entityClass)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata($entityClass));
        $this->entityManager = $entityManager;
    }

    public function findById(int $id): ?Lead
    {
        return $this->find($id);
    }

    public function findByEmail(string $email): ?Lead
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function save(Lead $lead): void
    {
        $this->entityManager->persist($lead);
        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $this->entityManager->delete($id);
        $this->entityManager->flush();
    }
}
