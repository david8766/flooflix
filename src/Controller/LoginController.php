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
        $login= $request->get('login');
        $pwd=$request->get('pwd');
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findByLog($login,$pwd);

        $session->set('connected', $user);

        return $this->redirectToRoute('home');
    }
}
