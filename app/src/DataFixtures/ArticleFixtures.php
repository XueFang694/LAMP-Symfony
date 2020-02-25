<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
        
        for($i = 0; $i < 10; $i++)
        {
            $articleFixture = new Article();
            $articleFixture->setContent("<p>Je suis le contenu $i</p>")
            ->setCreatedAt(new \DateTime())
            ->setImage("http://placeholder.it/$i")
            ->setName("Article $i");
            $manager->persist($articleFixture);
        }
        $manager->flush();
    }
}
