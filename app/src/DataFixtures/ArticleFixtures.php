<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;





class ArticleFixtures extends Fixture
{

    public function load( ObjectManager $manager )
    {
        for ( $i = 0; $i < 10; $i++ )
        {
            $article = new Article();
            $article->setName( "Titre de l'article #$i" )
                    ->setContent( "Contenu de l'article #$i" )
                    ->setImage( "http://placeholder.it/#$i" )
                    ->setCreatedAt( new \DateTime() );
            $manager->persist( $article );
        }

        $manager->flush();
    }

}




