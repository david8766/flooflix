<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\User;


class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function index()
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/login/log", name="log"  )
     */
    public function log(Request $request, SessionInterface $session)
    {
        $algo = PASSWORD_DEFAULT;
        $login= $request->get('login');
        var_dump($login);
        $pwd= password_hash($request->get('pwd'),$algo);
        echo($pwd);
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy(
            [
                'login' => $login  
            ]
        );
        $userLog = $user->getLogin(); 
        echo($userLog);  
        $pwdVerif = password_verify($pwd,$user->getPassword());
        echo($pwdVerif);
        /*
        if($userLog = $login && $pwdVerif == true)
        {
            $session->set('connected', $user);
        }
        else
        {
            $session->set('connected', null);
        } 
        */
        $session->set('connected', $user);
        return $this->redirectToRoute('home');
    }


}
