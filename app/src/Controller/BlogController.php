<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Entity\User;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\LoginType;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\SubscribeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\ORM\Repository\RepositoryFactory;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;

class BlogController extends AbstractController
{

    /**
     *
     * @Route("/", name="login")
     */
    public function login(Request $request, UserRepository $repo)
    {
        $user = new User();
        
        $form = $this->createForm( LoginType::class, $user );
        $form->add("password", PasswordType::class, [
            "label" => false,
            "attr" => ['placeholder' => 'Votre mot de passe']
        ]);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            
            $input = $form->getData();
            $checkUser = $repo->findBy([
                "login" => $input->getLogin(),
                "password" => $input->getPassword()
            ]);
            if(count($checkUser) === 0)
            {
                return $this->render( "blog/login.html.twig", [
                    "route" => $request->attributes->get('_route'),
                    "formLogin" => $form->createView(),
                    "unknowUser" => true,
                    "image" => "https://picsum.photos/id/3/200/200.jpg",
                    "background" => "https://picsum.photos/1920/1080"
                ] );
            }elseif (count($checkUser) === 1)
            {
                return $this->redirectToRoute( "blog" );
            }
        }

        return $this->render( "blog/login.html.twig", [
                    "route" => $request->attributes->get('_route'),
                    "formLogin" => $form->createView(),
                    "unknowUser" => false,
                    "image" => "https://picsum.photos/id/3/200/200.jpg",
                    "background" => "https://picsum.photos/1920/1080"
                ] );
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
    public function show( Article $article, Request $request, EntityManagerInterface $manager )
    {
        $comment = new Comment();


        $form = $this->createForm( CommentType::class, $comment );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() )
        {
            $comment->setCreatedAt( new \DateTime() )
                    ->setArticle( $article );
            $manager->persist( $comment );
            $manager->flush();
        }

        return $this->render( "blog/article.html.twig", [
                    "article" => $article,
                    "formComment" => $form->createView()
                ] );
    }

    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function subscribe(Request $request, EntityManagerInterface $manager, UserRepository $repo)
    {

        $user = new User();

        $form = $this->createForm(SubscribeType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $input = $form->getData();
            // Vérifie si l'utilisateur existe déjà
            $seekUser = $repo->findByLogin($input->getLogin());
            if( count($seekUser) > 0 )
            {
                $this->addFlash('error', 'Le compte existe déjà.');
                return $this->render("blog/subscribe.html.twig",
                [
                    "formSubscribe" => $form->createView()
                ]);
            }

            

            $user->setLogin($input->getLogin())
            ->setPassword($input->getPassword())
            ->setFirstname($input->getFirstname())
            ->setLastname($input->getLastname())
            ->setCreatedAt(new \DateTime())
            ->setLastConnect(new \DateTime());

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Le compte a bien été créé.');
            return $this->redirectToRoute("blog",
            [
                "login" => $user->getLogin()
            ]);
        }

        return $this->render("blog/subscribe.html.twig",
        [
            "formSubscribe" => $form->createView()
        ]);
    }
    
}




