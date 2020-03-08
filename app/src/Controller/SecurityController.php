<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\SubscribeType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/subscribe", name="security_subscribe")
     */
    public function subscribe(Request $request, EntityManagerInterface $manager, UserRepository $repo, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(SubscribeType::class, $user);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $input = $form->getData();
            $hash = $encoder->encodePassword( $user, $user->getPassword() );

            $user->setUsername($input->getUsername())
                    ->setPassword($hash)
                    ->setFirstname($input->getFirstname())
                    ->setLastname($input->getLastname())
                    ->setCreatedAt(new \DateTime())
                    ->setLastConnect(new \DateTime());
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("Success", "L'utilisateur a bien été créé.");
        }

        return $this->render('security/subscribe.html.twig', [
            'formSubscribe' => $form->createView()
        ]);
    }

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
