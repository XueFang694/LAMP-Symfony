<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;





class BlogController extends AbstractController
{

    /**
     * @Route("/blog/{id}", name="blog_id", methods={"GET","HEAD"})
     */
    public function list( string $id ): Response
    {
        return new Response( $id );
    }

}




