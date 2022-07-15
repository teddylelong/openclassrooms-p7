<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $iPhone12 = (new Product())
            ->setName('iPhone 12')
            ->setBrand('Apple')
            ->setDescription('As amazing as ever')
            ->setPrice(599)
        ;
        $manager->persist($iPhone12);

        $iPhone13 = (new Product())
            ->setName('iPhone 13')
            ->setBrand('Apple')
            ->setDescription('A total powerhouse')
            ->setPrice(699)
        ;
        $manager->persist($iPhone13);

        $iPhone13Pro = (new Product())
            ->setName('iPhone 13 Pro')
            ->setBrand('Apple')
            ->setDescription('The ultimate iPhone')
            ->setPrice(999)
        ;
        $manager->persist($iPhone13Pro);

        $iPhoneSE = (new Product())
            ->setName('iPhone SE 2022')
            ->setBrand('Apple')
            ->setDescription('Serious power. Serious value.')
            ->setPrice(429)
        ;
        $manager->persist($iPhoneSE);

        $samsungS20 = (new Product())
            ->setName('Galaxy S20')
            ->setBrand('Samsung')
            ->setDescription("Grand écran 6,5 pouces ultra fluide 120Hz")
            ->setPrice(499)
        ;
        $manager->persist($samsungS20);

        $samsungS22 = (new Product())
            ->setName('Galaxy S22')
            ->setBrand('Samsung')
            ->setDescription("Ecran Dynamic AMOLED de 6,1 pouces pour une immersion totale dans vos contenus")
            ->setPrice(799)
        ;
        $manager->persist($samsungS22);

        $manager->flush();
    }
}
