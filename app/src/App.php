<?php

namespace Yakovgulyuta\Hw13;

use Yakovgulyuta\Hw13\Entity\Cinema;

class App
{
 /**
  * @return void
  */
    public function run(): void
    {
//        $this->findAll();
//        $this->create();
//        $this->update(7);
//        $this->findOne(8);
//        $this->remove(7);
//        $this->lazy(7);
    }

    private function findAll(): array
    {
        $cinema = new Cinema();

        return $cinema->findAll();
    }

    private function findOne(int $id): Cinema|null
    {
        $cinema = new Cinema();

        return $cinema->read($id);
    }

    private function lazy(int $id): array|null
    {
        $cinema = new Cinema();
        $result = $cinema->read($id);

        return $result?->getSessions();
    }

    private function create(): int
    {
        $cinema = new Cinema();
        $cinema->setName('Новое кино');

        return $cinema->insert();
    }

    private function update(int $id): Cinema|null
    {
        $cinema = new Cinema();
        $cinema->setName('Новое кино обновил');
        $cinema->update($id);

        return $cinema;
    }

    private function remove(int $id): bool
    {
        $cinema = new Cinema();
        $cinema->delete($id);

        return true;
    }
}
