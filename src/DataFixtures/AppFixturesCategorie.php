<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixturesCategorie extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $candy = new Categorie();
            $candy->setName($faker->word());
            $candy->setDescription($faker->sentence());

          

            // Ajout de createdAt et updatedAt
            $candy->setCreateAt(new DateTimeImmutable());
            $candy->setUpdateAt(new DateTimeImmutable());


            $manager->persist($candy);
        }
        $manager->flush();
    }
}
