<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;





class UserFixtures extends Fixture
{

    public function load( ObjectManager $manager )
    {
        // $product = new Product();
        // $manager->persist($product);

        for ( $i = 0; $i < 35; $i++ )
        {
            $user = new User();
        }

        $manager->flush();
    }

}




