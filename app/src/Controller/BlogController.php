<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MaPremiereTable;
use App\Repository\MaPremiereTableRepository;





class BlogController extends AbstractController
{

    /*
     * @Route("/blog", name="blog")
     */
    /*public function list()
    {
        $repo = $this->getDoctrine()->getRepository( MaPremiereTable::class );
        $articles = $repo->findAll();
        return $this->render( "blog/default.html.twig", [
                    "articles" => $articles
                ] );
    }*/
    
    /**
     * Cette méthode est égale à la méthode précédente mais simplifie la syntaxe de l'injection de dépendance du repository
     * @Route("/blog", name="blog")
     */
    public function list( MaPremiereTableRepository $repo )
    {
        $articles = $repo->findAll();
        return $this->render( "blog/default.html.twig", [
            "articles" => $articles
        ] );
    }
    
    /**
     * @Route("/blog/GET/{id}", name="blog_display_article")
     */
    public function show( MaPremiereTable $article )
    {
        return $this->render("blog/article.twig.html", [
            "article" => $article
        ]);
    }

}




