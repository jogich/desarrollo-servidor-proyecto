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
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');

        $user = $repository->findAll();

        return $this->render('user/user-list.html.twig', array('user' => $user ));
    }

    /**
     * @Route("/user/update/{id}", name="user-update")
     */
    public function updateAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');

        $user = $repository->findAll();

        return $this->render('user/user-list.html.twig', array('user' => $user ));
    }


    // EXAMEN

    /**
     * @Route("/user/show/{name}", name="user-show-name") 
     */
    public function showByNameAction($name="Paco")
    {
        // almacenamos la entidad en una variable
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');

        // realizamos la búsqueda por nombre
        $user = $repository->findByName($name);

        // devolvemos los datos en un array
        return $this->render('user/user-show-name.html.twig', array('user' => $user));
    }

    /**
     * @Route("/user/show/id/{id}", name="user-show-one-id") 
     */
    public function showOneByNameAction($id)
    {
        // almacenamos la entidad en una variable
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');

        // realizamos la busqueda por el id
        $user = $repository->findById($id);

        // devolvemos los datos en un array
        return $this->render('user/user-show-one-id.html.twig', array('user' => $user));
    }


}
