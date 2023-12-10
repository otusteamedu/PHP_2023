<?php

namespace App\Domain\Repository;

use App\Domain\Entity\ApplicationForm;
use Doctrine\Common\Collections\Collection;

interface ApplicationFormInterface
{
    public function findOneById(int $id): ?ApplicationForm;

    public function findAll(): Collection;

    public function save(ApplicationForm $entity): void;

    public function delete(ApplicationForm $entity): void;
}
