<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\User;
use App\Entity\Role;


class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function index()
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }


    /**
     * @Route("/register/reg", name="register_reg" )
     */
    public function reg(Request $request)
    {
        
        $model = $this->getDoctrine()->getManager();
        $repository = $model->getRepository(User::class);
        $model2 = $this->getDoctrine()->getManager();
        $repository2 = $model2->getRepository(Role::class);

        
        $algo = PASSWORD_DEFAULT;
        $role = $repository2->find(3);
        

        $user = new User();
        $user -> setLastName($request->get('lastName'));
        $user -> setFirstName($request->get('firstName'));
        $user -> setMail($request->get('mail'));
        $user -> setLogin($request->get('login'));
        $user -> setPassword(password_hash($request->get('pwd'),$algo));
        $user -> setRegisterDate(new \DateTime('now'));
        $user -> setCredits(0);
        $user -> setRole($role);
       

        $model->persist($user);
        $model->flush();

        return $this->redirect($this->generateUrl('user_showRegister', array('id' => $user->getId())));
    
    }
}
