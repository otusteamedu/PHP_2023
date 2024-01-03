<?php

use Common\Application\Actions\User\AddAction;
use Common\Infrastructure\User\UserDTO;
use Doctrine\ORM\EntityManagerInterface;
use Phinx\Seed\AbstractSeed;

class UserTableSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $action = new AddAction(container()->get(EntityManagerInterface::class));

        $city = container()
            ->get(EntityManagerInterface::class)
            ->getRepository(\Geolocation\Domain\City::class)
            ->findOneBy(['name' => 'Almaty']);

        for ($i = 0; $i < 10; $i++) {
            $user = $action(new UserDTO(
                $faker->email,
                $faker->phoneNumber,
                $faker->password,
                $city,
                null,
                $faker->userName,
                $faker->firstName,
                $faker->lastName
            ));

            var_dump("User #{$user->getId()} created");
        }
    }
}
