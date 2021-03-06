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
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy(
            [
                'login' => $request->get('login')  
            ]
        );
        if(!is_null($user)){
              
            $pwdVerif = password_verify($request->get('pwd'),$user->getPassword());
            
            if($pwdVerif == true)
            {
                $session->set('connected', $user);
            }
            else
            {
                $session->set('connected', null);
            } 
            return $this->redirectToRoute('home');
        } else {
            return $this->redirectToRoute('home');
        }
    }


}
