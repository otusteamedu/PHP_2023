<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\ApplicationFormRepositoryInterface;
use App\Infrastructure\DataMapper\ApplicationFormMapper;
use App\Domain\Entity\ApplicationForm;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use ReflectionException;

class RepositoryApplicationFormDb implements ApplicationFormRepositoryInterface
{
    private ApplicationFormMapper $mapper;

    /**
     * @throws Exception
     */
    public function __construct(ApplicationFormMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function findOneById(int $id): ?ApplicationForm
    {
        return $this->mapper->findById($id);
    }

    /**
     * @throws ReflectionException
     */
    public function findAll(): Collection
    {
        return new ArrayCollection($this->mapper->findAll());
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function save(ApplicationForm $entity): void
    {
        if ($entity->getId() !== null) {
            $this->mapper->update($entity);
        } else {
            $this->mapper->insert($entity);
        }
    }

    public function delete(ApplicationForm $entity): void
    {
        // TODO: Implement delete() method.
    }
}