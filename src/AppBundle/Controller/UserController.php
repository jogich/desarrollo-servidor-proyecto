<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/register/", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form= $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render('user/register.html.twig', ['register_form' => $form->createView()]);
    }

    /**
     * @Route("/login/", name="login")
     */
    public function aboutAction()
    {
        return $this->render('user/login.html.twig');
    }

    /**
     * @Route("/user-list/", name="user-list")
     */
    public function showAction()
    {
        return $this->render('user/user-list.html.twig');
    }
}
