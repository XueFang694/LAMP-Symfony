<?php

// src/Controller/LuckyController.php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;





class LuckyController extends AbstractController
{

    /**
     * @Route("/lucky/number")
     */
    public function number()
    {
        $number = random_int( 0, 100 );

        return $this->render(
                        'body.html.twig', [ "numero" => $number ]
        );
    }

}




