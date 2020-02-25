<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;





class BlogController extends AbstractController
{

    /**
     *
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render( "blog/index.html.twig" );
    }

    /**
     *
     * @Route("/blog", name="blog")
     */
    public function list( ArticleRepository $repo )
    {
        $articles = $repo->findAll();
        return $this->render( "blog/articleList.html.twig", [
                    "articles" => $articles
                ] );
    }

    /**
     *
     * @Route("/blog/CREATE", name="blog_create")
     * @Route("/blog/{id}/UPDATE", name="blog_update")
     */
    public function form( Article $article = null, Request $request, EntityManagerInterface $manager )
    {
        if ( !$article )
        {
            $article = new Article();
        }
        $form = $this->createForm( ArticleType::class, $article );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() )
        {
            if ( !$article->getId() )
            {
                $article->setCreatedAt( new \DateTime() );
            }
            $manager->persist( $article );
            $manager->flush();

            return $this->redirectToRoute( "blog_display_article", [
                        'id' => $article->getId()
                    ] );
        }


        return $this->render( "blog/create.html.twig", [
                    "formArticle" => $form->createView(),
                    "articleExist" => $article->getId() !== null
                ] );
    }

    /**
     * @Route("/blog/GET/{id}", name="blog_display_article")
     */
    public function show( Article $article )
    {
        return $this->render( "blog/article.html.twig", [
                    "article" => $article
                ] );
    }

}




