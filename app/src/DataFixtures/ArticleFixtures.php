<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
        
        $faker = Factory::create("fr_FR");
        // Cr�� 3 cat�gories factices
        for($i = 0; $i < 3; $i++)
        {
            $category = new Category();
            $category->setName($faker->sentence())
            ->setDescription($faker->paragraph());
            $manager->persist($category);
            
            // Cr�� entre 4 et 6 articles dans la cat�gorie
            for($j = 1; $j < mt_rand(4, 6); $j++)
            {
                $content = "<p>" . join($faker->paragraphs(), "</p><p>") . "</p>";
                
                $articleFixture = new Article();
                $articleFixture->setContent($content)
                ->setCreatedAt(new \DateTime())
                ->setImage($faker->imageUrl($width = 200, $height = 300))
                ->setName($faker->sentence())
                ->setCategory($category);
                
                $manager->persist($articleFixture);
                
                for( $k = 1; $k <= mt_rand(4, 10); $k++)
                {
                    
                    $days = (new \DateTime())->diff($articleFixture->getCreatedAt())->days;
                    
                    $comment = new Comment();
                    $comment->setAuthor($faker->name())
                    ->setCreatedAt($faker->dateTimeBetween( '-'.$days.' days'))
                    ->setContent($faker->paragraph())
                    ->setArticle($articleFixture);
                    
                    $manager->persist($comment);
                }
            }
        }
        
        
        $manager->flush();
    }
}
