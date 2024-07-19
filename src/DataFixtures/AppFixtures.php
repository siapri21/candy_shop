<?php

namespace App\DataFixtures;

use App\Entity\Candy;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $candy = new Candy();
            $candy->setName($faker->word());
            $candy->setDescription($faker->sentence());

            $slug = $this->slugger->slug($candy->getName())->lower();
            $candy->setSlug($slug);

            // Ajout de createdAt et updatedAt
            $candy->setCreateAt(new DateTimeImmutable());

            $manager->persist($candy);
        }
        $manager->flush();
    }
}
