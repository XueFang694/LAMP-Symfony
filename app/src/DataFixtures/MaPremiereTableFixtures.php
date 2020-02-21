<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\MaPremiereTable;





class MaPremiereTableFixtures extends Fixture
{

    public function load( ObjectManager $manager )
    {
        for ( $i = 1; $i <= 10; $i++ )
        {
            $article = new MaPremiereTable();
            $article->setTitle( "Titre de l'article n°$i" )
                    ->setContent( "<p>Contenu de l'article n°$i</p>" )
                    ->setImage( "http://placehold.it/350x350" )
                    ->setCreatedAt( new \DateTime() );

            $manager->persist( $article );
        }

        $manager->flush();
    }

}




