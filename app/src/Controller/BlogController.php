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
    /* public function list()
      {
      $repo = $this->getDoctrine()->getRepository( MaPremiereTable::class );
      $articles = $repo->findAll();
      return $this->render( "blog/default.html.twig", [
      "articles" => $articles
      ] );
      } */

    /**
     *
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render( "blog/index.html.twig" );
    }

    /**
     * Cette m�thode est �gale � la m�thode pr�c�dente mais simplifie la syntaxe de l'injection de d�pendance du repository
     * @Route("/blog", name="blog")
     */
    public function list( MaPremiereTableRepository $repo )
    {
        $articles = $repo->findAll();
        return $this->render( "blog/articleList.html.twig", [
                    "articles" => $articles
                ] );
    }

    /**
     *
     * @Route("/blog/CREATE", name="blog_create")
     */
    public function create()
    {
        return $this->render( "blog/create.html.twig" );
    }

    /**
     * @Route("/blog/GET/{id}", name="blog_display_article")
     */
    public function show( MaPremiereTable $article )
    {
        return $this->render( "blog/article.html.twig", [
                    "article" => $article
                ] );
    }

}




