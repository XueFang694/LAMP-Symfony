<?php
declare(strict_types=1);

namespace App\Controller;
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use ElephantIO\Exception\ServerConnectionFailureException;
class AppController extends AbstractController
{
   /**
    * @Route("/addUser", name="addUser")
    */
    public function addUser(EntityManagerInterface $manager)
    {
        /*$user = new User();
        $user->setFirstname("Hello")
             ->setLastname("World")
             ->setCreatedAt(new \DateTime())
             ->setUsername("XueFang")
             ->setPassword("Bilibala");
        $manager->persist($user);
        $manager->flush();
        return new Response("Utiliseur ajouté");*/

        try
        {
            $token = 'this_is_peter_token';

            $client = new Client(new Version2X('http://localhost:9009', [
                'headers' => [
                    'X-My-Header: websocket rocks',
                    'Authorization: Bearer ' . $token,
                    'User: peter',
                ]
            ]));

            $data = [
                'message' => 'How are you?',
                'token' => $token,
            ];

            $client->initialize();
            $client->emit('private_chat_message', $data);
            $client->close();
        } catch (ServerConnectionFailureException $e) {
            dd($e->getErrorMessage());
        }
        return new Response("OK");
    }
}
