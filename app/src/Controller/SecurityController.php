<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     *
     * @Route("/login", name="security_login")
     */
    public function login(Request $request, UserRepository $repo)
    {
        $form = $this->createForm(LoginType::class);
        return $this->render( "security/login.html.twig", [
                    "formLogin" => $form->createView(),
                    "route" => $request->attributes->get('_route'),
                    "image" => "https://picsum.photos/id/3/200/200.jpg",
                    "background" => "https://picsum.photos/1920/1080"
                ] );
    }

    /**
     * @Route("/disconnect", name="security_logout")
     */
    public function logout()
    {
    }

}
