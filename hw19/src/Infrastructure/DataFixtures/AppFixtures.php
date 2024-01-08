<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Entity\Expense;
use App\Entity\Income;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private const ENTITIES_COUNT = 20;

    public function __construct(readonly ManagerRegistry $doctrine)
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadExpense($manager);
        $this->loadIncome($manager);
    }

    public function loadExpense(ObjectManager $manager)
    {
        for ($id = 1; $id <= self::ENTITIES_COUNT; ++$id) {
            $expense = new Expense();
            $expense->setDate($this->faker->dateTimeBetween('-10 days'));
            $expense->setAmount((string) $this->faker->randomFloat(0, -100, -5000));
            $expense->setCurrency('RUB');

            $manager->persist($expense);
        }
        $manager->flush();
    }

    public function loadIncome(ObjectManager $manager)
    {
        for ($id = 1; $id <= self::ENTITIES_COUNT; ++$id) {
            $income = new Income();
            $income->setDate($this->faker->dateTimeBetween('-10 days'));
            $income->setAmount((string) $this->faker->randomFloat(0, 100, 5000));
            $income->setCurrency('RUB');

            $manager->persist($income);
        }
        $manager->flush();
    }
}
