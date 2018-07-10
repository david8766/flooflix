<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(SessionInterface $session)
    {
        if(!is_null($session->get('connected')) and !empty($session->get('connected')))
        {
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'user' => $session->get('connected')->getFirstName(),
                'userRole' => $session->get('connected')->getRole(),
                'userId' => $session->get('connected')->getId()
            ]);
        } else {
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController'
            ]);
        }
    }

    /**
     * @Route("/home/quit", name="home_quit")
     */
    public function quit(SessionInterface $session){
        if(!is_null($session->get('connected')))
        {
            $session->set('connected', null);
            $session->save();
            
            return $this->render('home/quit.html.twig', [
                'controller_name' => 'HomeController'
            ]);
        }
    }
}
