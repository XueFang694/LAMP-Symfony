<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MaPremiereTable;





class BlogController extends AbstractController
{

    /**
     * @Route("/blog", name="blog")
     */
    public function list()
    {
        $repo = $this->getDoctrine()->getRepository( MaPremiereTable::class );
        $articles = $repo->findAll();
        return $this->render( "blog/default.html.twig", [
                    "articles" => $articles
                ] );
    }

}




