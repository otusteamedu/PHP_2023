<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\ApplicationForm;
use App\Domain\Repository\ApplicationFormInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Message;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ReflectionClass;

class DbRepository implements ApplicationFormInterface
{
    public function findOneById(int $id): ?ApplicationForm
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id]
        );
        $entities = array_map(function ($item) {
            return new ApplicationForm(new Email($item['email']), new Message($item['message']));
        }, $entities);

        return $entities ? $entities[0] : null;
    }

    public function findAll(): Collection
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '`;', []);
        $entities = array_map(function ($item) {
            return new ApplicationForm(new Email($item['email']), new Message($item['message']));
        }, $entities);

        return new ArrayCollection($entities);
    }

    public function save(ApplicationForm $entity): void
    {
        if ($entity->getId() !== null) {
            $this->update($entity);
        } else {
            $this->insert($entity);
        }
    }

    public function delete(ApplicationForm $entity): void
    {
        // TODO: Постараться не забыть сделать этот метод
    }

    protected static function getTableName(): string
    {
        return "application_form";
    }

    private function update(ApplicationForm $entity)
    {
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . '`email` = ?, `message` = ?' . ' WHERE id = ' . $entity->getId();
        $db = Db::getInstance();
        $db->query($sql, [$entity->getEmail()->getValue(), $entity->getMessage()->getValue()]);
    }

    private function insert(ApplicationForm $entity)
    {
        $sql = 'INSERT INTO ' . static::getTableName() . ' (`email`, `message`) VALUES (?, ?);';
        $db = Db::getInstance();
        $db->query($sql, [$entity->getEmail()->getValue(), $entity->getMessage()->getValue()]);
        $id = $db->getLastInsertId();

        $reflectionClass = new ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, $id);
    }
}
