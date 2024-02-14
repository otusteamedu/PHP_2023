<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\ApplicationForm;
use Doctrine\Common\Collections\Collection;

interface ApplicationFormRepositoryInterface
{
    public function findOneById(int $id): ?ApplicationForm;

    public function findAll(): Collection;

    public function save(ApplicationForm $entity): void;

    public function delete(ApplicationForm $entity): void;
}
