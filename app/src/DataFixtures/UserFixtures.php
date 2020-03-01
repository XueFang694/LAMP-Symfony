<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class UserFixtures extends Fixture
{

    public function load( ObjectManager $manager )
    {

        for ( $i = 0; $i < 35; $i++ )
        {
            
            $faker = Factory::create("fr_FR");
            
            $user = new User();
            $user->setLogin($faker->firstName)
            ->setPassword($faker->password)
            ->setCreatedAt(new \DateTime())
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName);
            $manager->persist($user);
        }

        $manager->flush();
    }
}



class GroupUserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
    }
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
